<div class="w-full p-10">
  <div class="border w-full p-2 mb-5">
    <h1 class="text-3xl font-bold">Post Form</h1>
    <form id="post-form" method="post" class="w-96 p-10 flex flex-col space-y-5">
      <input type="hidden" name="reply_to_id" value="">
      <input type="text" name="subject" class="border border-slate-900 rounded">
      <input type="text" name="content" class="border border-slate-900 rounded">
    
      <button type="submit" class="border border-slate-500 rounded hover:bg-slate-500 hover:text-white">Submit</button>
    </form>
  </div>
  <div class="border w-full p-5 flex space-x-3">
    <div class="flex flex-col space-y-3 h-[600px] w-[600px]  overflow-auto">
      <h1 class="text-3xl font-bold">Post List</h1>
      <?php if(count($posts) > 0) :?>
        <?php foreach($posts as $post): ?>
          <div class="w-96 border border-dotted p-4">
            <input type="checkbox" class="size-5" value="<?= $post->getId(); ?>">
            <div>
              <p class="text-xl font-semibold">Subject : <?= $post->getSubject(); ?></p>
            </div>
            <hr class="my-6">
            <div>
              <p class="text-sm font-semibold">Content : <?= $post->getContent(); ?></p>
            </div>
            <hr class="my-3">
            <div class="w-full pt-2 text-end">
              <button class="open-reply-button text-sm text-slate-500 hover:text-slate-900" data-id=<?= $post->getId(); ?>>show reply</button>
            </div>
            <div id="reply-content" class="flex flex-col space-y-4"></div>
          </div>
        <?php endforeach; ?>
      <?php else :?>
        <div>
          <p class="text-2xl">Nothing Posts</p>
        </div>
      <?php endif ; ?>
    </div>
    <div class="border w-full p-3 h-full">
      <h1 class="text-3xl font-bold">Reply Form</h1>
      <form id="reply-form" method="post" class="w-96 p-10 flex flex-col space-y-5">
        <textarea type="text" name="content" class="p-3 border border-slate-900 rounded"></textarea>
        <button type="submit" class="border border-slate-500 rounded hover:bg-slate-500 hover:text-white">Submit</button>
      </form>
    </div>
  </div>
</div>


<script>
  window.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('post-form')

    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const formData = new FormData(form);
      // console.log(form);
      const url = '/form/update/post';

      fetch(url, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then((data) => {
        // console.log(data); 

        if(data.status === 'success') {
          form.reset();
          window.location.reload();
        }
      })
    });

    const replyButtons = document.querySelectorAll('.open-reply-button');
    replyButtons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id');
        // console.log(id);
        const url = '/reply';
        fetch(url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({'id': id}),
        })
        .then(response => response.json())
        .then((data) => {
          // console.log(data.replies);
          const replies = data.replies;

          const replyContent = document.getElementById('reply-content');
          if(replies.length > 0) {
            replies.forEach(reply => {
              replyContent.innerHTML += 
              `
              <div class="w-96 border border-2 border-green-500 p-4">
                <p class="text-sm font-semibold">Content : ${reply['content']}</p>
              </div>
              `
            });
          }
        })
      })
    })

    const replyForm = document.getElementById('reply-form');
      replyForm.addEventListener('submit', function(e) {
        e.preventDefault()

        const replyFormData = new FormData(replyForm);

        const checkedValues = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                                  .map(checkbox => checkbox.value);
        
        if(checkedValues.length > 1 || checkedValues.length <= 0) {
          // TODO: Display error message to UI
          console.log('返信対象のPostが選択されていないか2個以上選択されています'); 
          return;
        }
        // console.log(checkedValues); 

        const checkedValue = checkedValues[0];
        replyFormData.append('reply_to_id', checkedValue);
        const url = '/form/update/reply';

        fetch(url, {
          method: "POST",
          body: replyFormData
        })
        .then(response => response.json())
        .then((data) => {
          // console.log(data);
          if(data.status === 'success') {
            form.reset();
            window.location.reload();
          }
        })
      })
    


















  })
</script>