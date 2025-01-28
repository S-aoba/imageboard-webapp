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
      'issi',
      [
        $postData->getId(),
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
    return false;
  }

  public function getById(int $id): ?Post
  {
    return null;
  }

  public function update(Post $postData): bool
  {
    return false;
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