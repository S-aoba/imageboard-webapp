<?php

namespace Models;

use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model {
  use GenericModel;

  public function __construct(
    private string $content,
    private ?string $subject = null,
    private ?int $id = null,
    private ?int $reply_to_id = null,
    private ?DataTimeStamp $timeStamp = null,
  ){}

  public function getId(): ?int {
    return $this->id;
  }

  public function setId(int $id): void {
      $this->id = $id;
  }

  public function getReplyToId(): ?int {
    return $this->reply_to_id;
  }

  public function setReplyToId(int $reply_to_id): void {
      $this->reply_to_id = $reply_to_id;
  }

  public function getSubject(): string {
    return $this->subject;
  }

  public function setSubject(string $subject): void {
      $this->subject = $subject;
  }

  public function getContent(): string {
    return $this->content;
  }

  public function setContent(string $content): void {
      $this->content = $content;
  }

  public function getTimeStamp(): ?DataTimeStamp
  {
      return $this->timeStamp;
  }

  public function setTimeStamp(DataTimeStamp $timeStamp): void
  {
      $this->timeStamp = $timeStamp;
  }

  public function toString(): string {
    return $this->toString();
  }
}