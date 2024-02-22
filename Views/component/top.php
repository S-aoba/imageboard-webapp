<div class="bg-white rounded-lg p-4 shadow mb-4">
  <h2 class="text-xl font-semibold mb-2">新しいスレッドを作成する</h2>
  <form id="postForm" action="#" method="POST">
    <div class="mb-4">
      <label for="subject" class="block text-gray-700 font-semibold">タイトル:</label>
      <input type="text" id="subject" name="subject" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドのタイトルを入力してください" required>
    </div>
    <div class="mb-4">
      <label for="content" class="block text-gray-700 font-semibold">内容:</label>
      <textarea id="content" name="content" rows="4" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドの内容を入力してください" required></textarea>
    </div>
    <button id="post" type="submit" class="bg-indigo-500 text-white font-semibold px-4 py-2 rounded hover:bg-indigo-600 transition duration-300">投稿する</button>
  </form>
</div>
<!-- スレッド一覧 -->
<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="text-xl font-semibold mb-4">スレッド一覧</h2>
  <!-- スレッド一覧の表示 -->
  <div class="space-y-4">
    <!-- スレッドのカード -->
    <?php foreach ($threads as $thread) : ?>
      <div class="bg-gray-200 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($thread->getSubject()) ?></h3>
        <div class="relative mb-2">
          <img src="/uploads/img/test.png" alt="スレッドイメージ" class="h-96 w-auto rounded-lg">
        </div>
        <p class="text-gray-500 mt-2">投稿日: <span id="postDate"><?= htmlspecialchars($thread->getTimeStamp()?->getUpdatedAt() ?? '') ?></span></p>
        <p class="text-gray-700"><?= htmlspecialchars($thread->getContent()) ?>。</p>
        <a href="#" class="text-indigo-600 font-semibold hover:underline mt-2 block read-more">続きを読む</a>

        <!-- 返信の部分を非表示にしておく -->
        <div class="bg-gray-100 rounded-lg p-4 mt-4 hidden replies">
          <h4 class="text-lg font-semibold mb-2">返信:</h4>
          <div class="flex items-center mb-2">
            <p class="text-gray-700 ml-2">返信の内容がここに表示されます。返信の内容がここに表示されます。</p>
          </div>
          <!-- 追加の返信 -->
          <div class="flex items-center mb-2">
            <p class="text-gray-700 ml-2">別の返信の内容がここに表示されます。別の返信の内容がここに表示されます。</p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
    <!-- 他のスレッドのカードもここに追加 -->
  </div>
</div>
<script src="/js/threads.js"></script>
