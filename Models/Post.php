<?php

namespace Models;

use DateTime;
use Models\Interfaces\Model;
use Models\Traits\GenericModel;

class Post implements Model {
  use GenericModel;

  public function __construct(
    private string $subject,
    private string $content,
    private ?int $id,
    private ?DataTimeStamp $timeStamp = null,
  ){}

  public function getId(): ?int {
    return $this->id;
  }

  public function setId(int $id): void {
      $this->id = $id;
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
}