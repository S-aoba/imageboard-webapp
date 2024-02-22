<div class="bg-white rounded-lg p-4 shadow mb-4">
  <h2 class="text-xl font-semibold mb-2">新しいスレッドを作成する</h2>
  <form id="postForm" action="#" method="POST" enctype="multipart/form-data">
    <div class="mb-4">
      <label for="subject" class="block text-gray-700 font-semibold">タイトル:</label>
      <input type="text" id="subject" name="subject" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドのタイトルを入力してください" required>
    </div>
    <div class="mb-4">
      <label for="content" class="block text-gray-700 font-semibold">内容:</label>
      <textarea id="content" name="content" rows="4" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドの内容を入力してください" required></textarea>
    </div>
    <div class="mb-4">
      <label for="image" class="block text-gray-700 font-semibold">画像を選択:</label>
      <input type="file" id="image" name="image" accept="image/*" class="border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" onchange="previewImage(event)"> <!-- onchange属性を追加してファイル選択時にイベントを発生させる -->
    </div>
    <!-- 画像プレビュー用の要素 -->
    <img id="preview-image" src="" class="max-h-96 w-auto rounded-lg">
    <button id="post" type="submit" class="bg-indigo-500 text-white font-semibold mt-2 px-4 py-2 rounded hover:bg-indigo-600 transition duration-300">投稿する</button>
  </form>
</div>


<!-- スレッド一覧 -->
<div class="bg-white rounded-lg p-4 shadow mb-4">
  <h2 class="text-xl font-semibold mb-4">スレッド一覧</h2>
  <!-- スレッド一覧の表示 -->
  <div class="space-y-4">
    <!-- スレッドのカード -->
    <?php foreach ($data_list as $data) : ?>
      <div class="bg-gray-200 rounded-lg p-4">
        <h3 class="text-2xl font-semibold mb-2 border-b border-gray-600"><?= htmlspecialchars($data["post"]->getSubject()) ?></h3>
        <div class="relative mb-2 border-b border-gray-600">
          <img src="/<?= htmlspecialchars($data["thumbnail"]) ?>" alt="スレッドイメージ" class="h-96 w-auto rounded-lg">
        </div>
        <p class="text-gray-500 mt-2">投稿日: <span id="postDate"><?= htmlspecialchars($data["post"]->getTimeStamp()?->getUpdatedAt() ?? '') ?></span></p>
        <p class="text-gray-700"><?= htmlspecialchars($data["post"]->getContent()) ?>。</p>
        <?php if (count($data["replies"]) > 0) : ?>
          <a href="#" class="text-indigo-600 font-semibold hover:underline mt-2 block read-more">続きを読む</a>
          <!-- 返信の部分を非表示にしておく -->
          <div class="bg-gray-100 rounded-lg p-4 mt-4 hidden replies">
            <h4 class="text-lg font-semibold mb-2">返信:</h4>
            <?php foreach ($data["replies"] as $reply) : ?>
              <p class="text-gray-500 mt-2">投稿日: <span id="replyDate"><?= htmlspecialchars($reply->getTimeStamp()?->getUpdatedAt() ?? '') ?></span></p>
              <div class="flex items-center mb-2">
                <p class="text-gray-700 ml-2"><?= htmlspecialchars($reply->getContent()) ?></p>
              </div>
              <hr class="my-4 border-gray-300">
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <a href="#" class="text-indigo-600 font-semibold hover:underline mt-2 block reply-form-toggle">返信する</a>
        <div class="bg-white rounded-lg p-4 shadow my-4 hidden reply-form">
          <h2 class="text-xl font-semibold mb-2">返信する</h2>
          <!-- 返信用フォーム -->
          <form id="replyPostForm" action="#" method="POST">
            <?php if ($data["post"]?->getId() !== null) : ?>
              <input type="hidden" name="reply_to_id" value="<?= $data["post"]->getId() ?>" placeholder="ID"><br>
            <?php endif; ?>
            <div class="mb-4">
              <label for="replyContent" class="block text-gray-700 font-semibold">返信内容:</label>
              <textarea id="content" name="content" rows="4" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="返信内容を入力してください" required></textarea>
            </div>
            <button id="replyPost" type="submit" class="bg-indigo-500 text-white font-semibold px-4 py-2 rounded hover:bg-indigo-600 transition duration-300">返信する</button>
          </form>
        </div>
      </div>
      <!-- 返信用フォーム -->
    <?php endforeach; ?>
    <!-- 他のスレッドのカードもここに追加 -->
  </div>
</div>

<script src="/js/threads.js"></script>
