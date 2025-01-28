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
  <div class="border w-full p-2 flex flex-col space-y-3">
    <h1 class="text-3xl font-bold">Post List</h1>
    <?php if(count($posts) > 0) :?>
      <?php foreach($posts as $post): ?>
        <div class="w-96 border border-dotted p-4">
          <div>
            <p class="text-xl font-semibold">Subject : <?= $post->getSubject() ?></p>
          </div>
          <hr class="my-6">
          <div>
            <p class="text-sm font-semibold">Content : <?= $post->getContent() ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else :?>
      <div>
        <p class="text-2xl">Nothing Posts</p>
      </div>
    <?php endif ; ?>
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
        console.log(data); 

        if(data.status === 'success') {
          form.reset();
          window.location.reload();
        }
      })
    });




















  })
</script>