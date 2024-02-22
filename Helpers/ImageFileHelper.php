<?php

namespace Helpers;

use Models\Post;

class ImageFileHelper
{
  public static function hashedFileName(Post $post): string
  {
    // hash値.拡張子
    // 画像のファイル名をidとcreated_atを使ってハッシュ化する
    return md5($post->getId() . $post->getTimeStamp()->getCreatedAt());
  }

  public static function saveImageFile(string $hashed_file_name, string $extension): void
  {
    $root_dir = "uploads/img/";
    $parent_dir = substr($hashed_file_name, 0, 2);

    // $parent_dirが存在しているかどうか
    if (!is_dir($root_dir . $parent_dir)) {
      mkdir($root_dir . $parent_dir, 0777, true);
    }
    $target_file = $root_dir . $parent_dir . '/' . $hashed_file_name . "." . $extension;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  }

  public static function getImageFile(string $hashed_file_name)
  {
    $root_dir = "uploads/img/";
    $parent_dir = substr($hashed_file_name, 0, 2);


    $directory = $root_dir . $parent_dir;

    $files = glob($directory . '/*');
    if (count($files) > 0) {
      return $files[0];
    }
  }
}
