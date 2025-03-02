<div class="w-[1100px] my-10">
  <h2 class="text-2xl mb-6">Overview</h2>

  <section class="mb-6">
    <h3 class="text-xl mb-4">Stats</h3>
    <p class="text-white font-medium">Total Posts: <?= $totalPosts; ?></p>
    <p class="text-white font-medium">Total Comments: <?= $totalComments; ?></p>
  </section>

  <section>
    <h3 class="text-xl mb-4">Recent Posts</h3>
    <ul class="grid grid-cols-3 mb-10 gap-10">
      <?php foreach($recentPosts as $post): ?>
        <li class="bg-white rounded-lg p-6">
          <a class="text-lg font-medium mb-4 underline underline-offset-1" href="/posts/<?= $post->id ?>"><?= $post->title ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </section>
</div>