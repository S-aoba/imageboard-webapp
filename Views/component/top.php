<div class="bg-white rounded-lg p-4 shadow mb-4">
  <h2 class="text-xl font-semibold mb-2">新しいスレッドを作成する</h2>
  <form action="#" method="POST">
    <div class="mb-4">
      <label for="title" class="block text-gray-700 font-semibold">タイトル:</label>
      <input type="text" id="title" name="title" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドのタイトルを入力してください" required>
    </div>
    <div class="mb-4">
      <label for="content" class="block text-gray-700 font-semibold">内容:</label>
      <textarea id="content" name="content" rows="4" class="w-full border-gray-300 rounded-md p-2 focus:outline-none focus:border-indigo-500" placeholder="スレッドの内容を入力してください" required></textarea>
    </div>
    <button type="submit" class="bg-indigo-500 text-white font-semibold px-4 py-2 rounded hover:bg-indigo-600 transition duration-300">投稿する</button>
  </form>
</div>

<!-- スレッド一覧 -->
<div class="bg-white rounded-lg p-4 shadow">
  <h2 class="text-xl font-semibold mb-4">スレッド一覧</h2>
  <!-- スレッド一覧の表示 -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- スレッドのカード -->
    <div class="bg-gray-200 rounded-lg p-4">
      <h3 class="text-lg font-semibold mb-2">スレッドタイトル</h3>
      <p class="text-gray-700">スレッドの内容がここに表示されます。スレッドの内容がここに表示されます。スレッドの内容がここに表示されます。</p>
      <a href="#" class="text-indigo-600 font-semibold hover:underline mt-2 block">続きを読む</a>
    </div>
    <!-- 他のスレッドのカードをここに追加 -->
  </div>
</div>
