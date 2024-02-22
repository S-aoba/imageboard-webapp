<?php

use Helpers\ValidationHelper;
use Models\Post;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Database\DataAccess\Implementations\PostDAOImpl;
use Helpers\ImageFileHelper;
use Response\Render\JSONRenderer;
use Types\ValueType;

return [
  // 'random/part' => function (): HTTPRenderer {
  //   $partDao = new ComputerPartDAOImpl();
  //   $part = $partDao->getRandom();

  //   if ($part === null) throw new Exception('No parts are available!');

  //   return new HTMLRenderer('component/computer-part-card', ['part' => $part]);
  // },
  // 'parts' => function (): HTTPRenderer {
  //   // IDの検証
  //   $id = ValidationHelper::integer($_GET['id'] ?? null);

  //   $partDao = new ComputerPartDAOImpl();
  //   $part = $partDao->getById($id);

  //   if ($part === null) throw new Exception('Specified part was not found!');

  //   return new HTMLRenderer('component/computer-part-card', ['part' => $part]);
  // },
  // 'update/part' => function (): HTMLRenderer {
  //   $part = null;
  //   $partDao = new ComputerPartDAOImpl();
  //   if (isset($_GET['id'])) {
  //     $id = ValidationHelper::integer($_GET['id']);
  //     $part = $partDao->getById($id);
  //   }
  //   return new HTMLRenderer('component/update-computer-part', ['part' => $part]);
  // },
  // 'form/update/part' => function (): HTTPRenderer {
  //   try {
  //     // リクエストメソッドがPOSTかどうかをチェックします
  //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  //       throw new Exception('Invalid request method!');
  //     }

  //     $required_fields = [
  //       'name' => ValueType::STRING,
  //       'type' => ValueType::STRING,
  //       'brand' => ValueType::STRING,
  //       'modelNumber' => ValueType::STRING,
  //       'releaseDate' => ValueType::DATE,
  //       'description' => ValueType::STRING,
  //       'performanceScore' => ValueType::INT,
  //       'marketPrice' => ValueType::FLOAT,
  //       'rsm' => ValueType::FLOAT,
  //       'powerConsumptionW' => ValueType::FLOAT,
  //       'lengthM' => ValueType::FLOAT,
  //       'widthM' => ValueType::FLOAT,
  //       'heightM' => ValueType::FLOAT,
  //       'lifespan' => ValueType::INT,
  //     ];

  //     $partDao = new ComputerPartDAOImpl();

  //     // 入力に対する単純なバリデーション。実際のシナリオでは、要件を満たす完全なバリデーションが必要になることがあります。
  //     $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

  //     if (isset($_POST['id'])) $validatedData['id'] = ValidationHelper::integer($_POST['id']);

  //     // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
  //     $part = new ComputerPart(...$validatedData);

  //     error_log(json_encode($part->toArray(), JSON_PRETTY_PRINT));

  //     // 新しい部品情報でデータベースの更新を試みます。
  //     // 別の方法として、createOrUpdateを実行することもできます。
  //     if (isset($validatedData['id'])) $success = $partDao->update($part);
  //     else $success = $partDao->create($part);

  //     if (!$success) {
  //       throw new Exception('Database update failed!');
  //     }

  //     return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
  //   } catch (\InvalidArgumentException $e) {
  //     error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
  //     return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
  //   } catch (Exception $e) {
  //     error_log($e->getMessage());
  //     return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
  //   }
  // },
  "top" => function (): HTTPRenderer {

    $postDao = new PostDAOImpl();
    $posts = $postDao->getAllThreads(0, 5);

    $data_list = []; // [ {"post": $post, "replies": $replies} ]

    foreach ($posts as $post) {
      $replies = $postDao->getReplies($post, 0, 5);
      $thumbnail = ImageFileHelper::getImageFile(ImageFileHelper::hashedFileName($post));

      $data_list[] = [
        "post" => $post,
        "replies" => $replies,
        "thumbnail" => $thumbnail
      ];
    }


    return new  HTMLRenderer('component/top', ['data_list' => $data_list]);
  },
  "form/post/thread" => function (): HTTPRenderer {
    try {
      // リクエストメソッドがPOSTかどうかをチェックします
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method!');
      }

      $required_fields = [
        'content' => ValueType::STRING,
        'subject' => ValueType::STRING,
      ];
      $postDao = new PostDAOImpl();
      $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

      // 画像を取得して/public/uploads/img/配下にファイル名をハッシュ化して保存
      $image = $_FILES['image'];
      // idとcreated_atを使ってファイル名をハッシュ化
      // 画像の拡張子を取得
      $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
      if (!ValidationHelper::checkFileExtension($extension)) {
        return new JSONRenderer(['status' => 'Invalid File Type', 'message' => 'ご利用の画像の形式はサポートされていません。jpeg、png、gif のいずれかをお試しください。']);
      }

      // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
      $postData = new Post(...$validatedData);

      error_log(json_encode($postData->toArray(), JSON_PRETTY_PRINT));

      // 新しい部品情報でデータベースの更新を試みます。
      // 別の方法として、createOrUpdateを実行することもできます。
      if (isset($validatedData['id'])) $success = $postDao->update($postData);
      else $success = $postDao->create($postData);

      if (!$success) {
        throw new Exception('Thread create failed!');
      }

      ImageFileHelper::saveImageFile(ImageFileHelper::hashedFileName($postData), $extension);

      return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
    } catch (\InvalidArgumentException $e) {
      error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
      return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
    } catch (Exception $e) {
      error_log($e->getMessage());
      return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
    }
  },

  "form/post/reply" => function (): HTTPRenderer {
    try {
      // リクエストメソッドがPOSTかどうかをチェックします
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method!');
      }

      $required_fields = [
        'content' => ValueType::STRING,
        'reply_to_id' => ValueType::INT,
      ];
      $postDao = new PostDAOImpl();
      $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

      // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
      $postData = new Post(...$validatedData);

      error_log(json_encode($postData->toArray(), JSON_PRETTY_PRINT));

      // 新しい部品情報でデータベースの更新を試みます。
      // 別の方法として、createOrUpdateを実行することもできます。
      $success = $postDao->create($postData);

      if (!$success) {
        throw new Exception('Thread create failed!');
      }

      return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
    } catch (Exception $e) {
      error_log($e->getMessage());
      return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
    } catch (\InvalidArgumentException $e) {
      error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
      return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
    }
  },

];
