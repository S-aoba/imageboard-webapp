<form id="post-form" method="post" class="w-96 p-10 flex flex-col space-y-5">
  <input type="hidden" name="reply_to_id" value="">
  <input type="text" name="subject" class="border border-slate-900 rounded">
  <input type="text" name="content" class="border border-slate-900 rounded">

  <button type="submit" class="border border-slate-500 rounded hover:bg-slate-500 hover:text-white">Submit</button>
</form>

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
      })
    });




















  })
</script>