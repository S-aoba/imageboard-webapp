<?php

namespace Database\DataAccess\Implementations;

use Database\DataAccess\Interfaces\PostDAO;
use Database\DatabaseManager;
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
    return [];
  }
  public function getReplies(Post $postData, int $offset, int $limit): array
  {
    return [];
  }
}