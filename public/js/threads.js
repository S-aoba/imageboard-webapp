// 続きを読むリンクをクリックした際に返信を表示する
const readMoreLinks = document.querySelectorAll('.read-more');

readMoreLinks.forEach((readMoreLink) => {
  readMoreLink.addEventListener('click', function (event) {
    event.preventDefault();
    const replies = this.closest('.bg-gray-200').querySelector('.replies');
    replies.classList.toggle('hidden');
  });
});

const form = document.getElementById('postForm');

form.addEventListener('submit', function (event) {
  event.preventDefault();

  const formData = new FormData(form);
  fetch('/form/post/thread', {
    method: 'POST',
    body: formData,
  }).then((response) => {
    response
      .json()
      .then((data) => {
        if (data.status === 'success') {
          form.reset();
          alert('スレッドを作成しました');
          // if (!formData.has('id')) form.reset(); 後ほど実装
        } else if (data.status === 'error') {
          // ユーザーにエラーメッセージを表示します
          console.error(data.message);
          alert('作成に失敗しました。再度やり直してください。: ' + data.message);
        }
      })
      .catch((error) => {
        // ネットワークエラーかJSONの解析エラー
        console.error('Error:', error);
        alert('時間を置いてから再度実行してください.');
      });
  });
});
