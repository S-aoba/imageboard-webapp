<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;


class Post implements Model
{
  use GenericModel;

  public function __construct(
    private ?int $id = null,
    private ?int $replay_to_id = null,
    private ?string $subject = null,
    private string $content,
    private DataTimeStamp $created_at,
    private DataTimeStamp $updated_at
  ) {
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getReplayId(): ?int
  {
    return $this->replay_to_id;
  }

  public function setReplayId(int $replay_to_id): void
  {
    $this->replay_to_id = $replay_to_id;
  }

  public function getSubject(): ?string
  {
    return $this->subject;
  }

  public function setSubject(string $subject): void
  {
    $this->subject = $subject;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  public function setContent(string $content): void
  {
    $this->content = $content;
  }

  public function getCreatedAt(): DataTimeStamp
  {
    return $this->created_at;
  }

  public function setCreatedAt(DataTimeStamp $created_at): void
  {
    $this->created_at = $created_at;
  }

  public function getUpdatedAt(): DataTimeStamp
  {
    return $this->updated_at;
  }

  public function setUpdatedAt(DataTimeStamp $updated_at): void
  {
    $this->updated_at = $updated_at;
  }
}
