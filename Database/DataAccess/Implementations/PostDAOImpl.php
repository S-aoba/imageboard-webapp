<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Helpers\DatabaseHelper;
use Models\DataTimeStamp;
use Models\Post;

class PostDAOImpl implements PostDAO {
  public function createOrUpdate(Post $postData): bool
  {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = 
    <<<SQL
      INSERT INTO posts (id, reply_to_id, subject, content) VALUES (?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE id = ?,
      reply_to_id = VALUES(reply_to_id),
      subject = VALUES(subject),
      content = VALUES(content);
    SQL;

    $result = $mysqli->prepareAndExecute(
      $query,
      'iissi',
      [
        $postData->getId(),
        $postData->getReplyToId(),
        $postData->getSubject(),
        $postData->getContent(),
        $postData->getId()
      ],
    );

    if(!$result) return false;

    if($postData->getId() === null) {
      $postData->setId($mysqli->insert_id);
      $timeStamp = $postData->getTimeStamp() ?? new DataTimeStamp(date('Y-m-d'), date('Y-m-d'));
      $postData->setTimeStamp($timeStamp);
    }

    return true;
  }

  public function create(Post $postData): bool
  {
    if($postData->getId() !== null) throw new \Exception('Cannot create a post with an existing ID. id: ' . $postData->getId());
        return $this->createOrUpdate($postData);
  }

  public function getById(int $id): ?Post
  {
    return null;
  }

  public function update(Post $postData): bool
  {
    if($postData->getId() === null) throw new \Exception('Post specified has no ID.');

    $current = $this->getById($postData->getId());
    if($current === null) throw new \Exception(sprintf("Post %s does not exist.", $postData->getId()));

    return $this->createOrUpdate($postData);
  }

  public function delete(int $id): bool
  {
    return false;
  }

  public function getAllThreads(int $offset, int $limit): array
  {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = "SELECT * FROM posts LIMIT ?, ?";
    $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);
    return $results === null ? [] : $this->resultsToPosts($results);
  }

  public function getPostById(int $id): Post {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = "SELECT * FROM posts where id = ?";
    $results = $mysqli->prepareAndFetchAll($query, 'i', [$id]);
    // error_log(var_export($results, true));

    return $results === null ? [] : $this->resultToPost($results[0]);
  }

  public function getReplies(Post $postData, int $offset, int $limit): array
  {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = "SELECT * FROM posts WHERE reply_to_id = ? LIMIT ?, ?";
    $results = $mysqli->prepareAndFetchAll($query, 'iii', [$postData->getId(), $offset, $limit]);
    
    return $results === null ? [] : $this->resultsToPosts($results);
  }

  private function resultsToPosts(array $results): array {
    $posts = [];

    foreach($results as $result) {
      $posts[] = $this->resultToPost($result);
    }

    return $posts;
  }

  private function resultToPost(array $data): Post {
    return new Post (
      subject: $data['subject'],
      content: $data['content'],
      reply_to_id: $data['reply_to_id'],
      id: $data['id'],
      timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'])
    );
  }
}