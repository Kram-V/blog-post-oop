<div class="w-[1100px] my-10">
  <h2 class="text-2xl">Recent Posts</h2>

  <div class="grid grid-cols-3 mt-10 mb-10 gap-10">
    <?php foreach($posts as $post): ?>
      <article class="bg-white rounded-lg p-6">
        <h3 class="text-lg font-medium mb-4 underline underline-offset-1">
          <a href="posts/<?= $post->id; ?>"><?= htmlspecialchars($post->title); ?></a>
        </h3>
        <p>
          <?php if(strlen($post->content) >= 100): ?>
            <?= htmlspecialchars(substr($post->content, 0, 100)); ?>...
          <?php else: ?>
            <?= htmlspecialchars($post->content); ?>
          <?php endif; ?>
        </p>  
      </article>
    <?php endforeach; ?>
  </div>
</div>