<div class="bg-white w-[400px] p-6 rounded-lg mt-10">
  <h2 class="text-center mb-5 text-xl">Create New Post</h2>

  <form action="/posts" method="POST" class="flex flex-col gap-4">
    <?= csrf_token(); ?> 

    <div>
      <label for="title">Title</label> <br />
      <input class="border-2 w-full" type="text" id="title" name="title" required>
    </div>

    <div>
      <label for="content">Content</label> <br />
      <textarea class="border-2 w-full" name="content" id="content" required></textarea>
    </div>

    <button class="bg-gray-800 py-2 text-white" type="submit">Submit</button>
  </form>
</div>