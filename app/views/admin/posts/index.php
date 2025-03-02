<div class="w-[1100px] my-10">
  <h2 class="text-2xl mb-6">Manage Posts</h2>

  <table class="w-full border border-gray-300 border-collapse">
    <thead>
      <tr class="bg-gray-100 border border-gray-300">
        <th class="text-start w-[750px]">Title</th>
        <th class="text-start w-[400px]">Created At</th>
        <th class="text-start">Actions</th> 
      </tr>
    </thead>

    <tbody>
      <?php foreach($posts as $post): ?>
        <tr class="border border-gray-300">
          <td><?= htmlspecialchars($post->title) ?></td>
          <td><?= htmlspecialchars($post->created_at) ?></td>
          <td class="flex gap-2 py-2">
            <a class="bg-white px-2 rounded-lg" href="/admin/posts/<?= $post->id ?>/edit">Edit</a>
            <form action="/admin/posts/<?= $post->id ?>/delete" method="POST">
              <?= csrf_token(); ?>
              <button class="bg-white px-2 rounded-lg" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>