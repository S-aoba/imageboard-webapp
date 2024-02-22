<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
use Models\Post;
use Models\DataTimeStamp;


class PostDAOImpl implements PostDAO
{
  public function create(Post $postData): bool
  {
    if ($postData->getId() !== null) throw new \Exception('Cannot create a post with an existing ID. id: ' . $postData->getId());
    return $this->createOrUpdate($postData);
  }

  public function getById(int $id): ?Post
  {
    $mysqli = DatabaseManager::getMysqliConnection();
    $post = $mysqli->prepareAndFetchAll("SELECT * FROM posts WHERE id = ?", 'i', [$id])[0] ?? null;

    return $post === null ? null : $this->resultToPost($post);
  }

  public function update(Post $postData): bool
  {
    if ($postData->getId() === null) throw new \Exception('Post specified has no ID.');

    $current = $this->getById($postData->getId());
    if ($current === null) throw new \Exception(sprintf("Post %s does not exist.", $postData->getId()));

    return $this->createOrUpdate($postData);
  }

  public function delete(int $id): bool
  {
    $mysqli = DatabaseManager::getMysqliConnection();
    $result = $mysqli->prepareAndExecute("DELETE FROM posts WHERE id = ?", 'i', [$id]);
    return $result;
  }

  public function createOrUpdate(Post $postData): bool
  {
    $mysqli = DatabaseManager::getMysqliConnection();
    $query =
      <<<SQL
        INSERT INTO posts (reply_to_id, subject, content)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE
        reply_to_id = VALUES(reply_to_id),
        subject = VALUES(subject),
        content = VALUES(content);
    SQL;

    $result = $mysqli->prepareAndExecute(
      $query,
      'iss',
      [
        $postData->getReplyToId(),
        $postData->getSubject(),
        $postData->getContent(),
      ]
    );
    if (!$result) return false;

    // insert_id returns the last inserted ID.
    if ($postData->getId() === null) {
      $postData->setId($mysqli->insert_id);
      $timeStamp = $postData->getTimeStamp() ?? new DataTimeStamp(date('Y-m-h'), date('Y-m-h'));
      $postData->setTimeStamp($timeStamp);
    }
    return true;
  }

  public function getAllThreads(int $offset, int $limit): array
  {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = "SELECT * FROM posts LIMIT ?, ?";

    $results = $mysqli->prepareAndFetchAll($query, 'ii', [$offset, $limit]);
    
    return $results === null ? [] : $this->resultsPosts($results);
  }

  public function getReplies(Post $postData, int $offset, int $limit): array
  {
    $mysqli = DatabaseManager::getMysqliConnection();

    $query = "SELECT * FROM posts WHERE reply_to_id = ? LIMIT ?, ?";

    $results = $mysqli->prepareAndFetchAll($query, 'iii', [$postData->getId(), $offset, $limit]);


    return $results === null ? [] : $this->resultsPosts($results);
  }

  private function resultToPost(array $data): Post
  {
    return new Post(
      content: $data['content'],
      subject: $data['subject'],
      id: $data['id'],
      reply_to_id: $data['reply_to_id'],
      timeStamp: new DataTimeStamp($data['created_at'], $data['updated_at'])
    );
  }

  private function resultsPosts(array $results): array
  {
    $posts = [];
    foreach ($results as $result) {
      $posts[] = $this->resultToPost($result);
    }
    return $posts;
  }
}
