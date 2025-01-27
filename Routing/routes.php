<?php

use Helpers\DatabaseHelper;
use Helpers\ValidationHelper;
use Models\ComputerPart;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Response\Render\JSONRenderer;
use Database\DataAccess\Implementations\ComputerPartDAOImpl;
use Types\ValueType;

return [
    // サンプルコードとして置いておく。
    // 'update/part' => function(): HTMLRenderer {
    //     $part = null;
    //     $partDao = new ComputerPartDAOImpl();
    //     if(isset($_GET['id'])){
    //         $id = ValidationHelper::integer($_GET['id']);
    //         $part = $partDao->getById($id);
    //     }
    //     return new HTMLRenderer('component/update-computer-part',['part'=>$part]);
    // },
    // 'form/update/part' => function(): HTTPRenderer {
    //     try {
    //         // リクエストメソッドがPOSTかどうかをチェックします
    //         if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //             throw new Exception('Invalid request method!');
    //         }

    //         $required_fields = [
    //             'name' => ValueType::STRING,
    //             'type' => ValueType::STRING,
    //             'brand' => ValueType::STRING,
    //             'modelNumber' => ValueType::STRING,
    //             'releaseDate' => ValueType::DATE,
    //             'description' => ValueType::STRING,
    //             'performanceScore' => ValueType::INT,
    //             'marketPrice' => ValueType::FLOAT,
    //             'rsm' => ValueType::FLOAT,
    //             'powerConsumptionW' => ValueType::FLOAT,
    //             'lengthM' => ValueType::FLOAT,
    //             'widthM' => ValueType::FLOAT,
    //             'heightM' => ValueType::FLOAT,
    //             'lifespan' => ValueType::INT,
    //         ];

    //         $partDao = new ComputerPartDAOImpl();

    //         // 入力に対する単純なバリデーション。実際のシナリオでは、要件を満たす完全なバリデーションが必要になることがあります。
    //         $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

    //         if(isset($_POST['id'])) $validatedData['id'] = ValidationHelper::integer($_POST['id']);

    //         // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
    //         $part = new ComputerPart(...$validatedData);

    //         error_log(json_encode($part->toArray(), JSON_PRETTY_PRINT));

    //         // 新しい部品情報でデータベースの更新を試みます。
    //         // 別の方法として、createOrUpdateを実行することもできます。
    //         if(isset($validatedData['id'])) $success = $partDao->update($part);
    //         else $success = $partDao->create($part);

    //         if (!$success) {
    //             throw new Exception('Database update failed!');
    //         }

    //         return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
    //     } catch (\InvalidArgumentException $e) {
    //         error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
    //         return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
    //     } catch (Exception $e) {
    //         error_log($e->getMessage());
    //         return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
    //     }
    // },
];