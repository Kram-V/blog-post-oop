<div class="w-[1100px] my-10">
  <article class="mb-10">
    <h1 class="text-3xl mb-4"><?= htmlspecialchars($post->title); ?></h1>
    <p><?= nl2br(htmlspecialchars($post->content)); ?></p>
  </article>

  <section>
    <h2 class="text-2xl mb-4" id="comments">Comments</h2>

    <?php if($user && $user->role ==='non-admin'): ?>
      <form action="/posts/<?= $post->id ?>/comments" method="POST" class="mb-6">
        <?= csrf_token(); ?>

        <textarea class="w-[400px]" name="content" rows="5" required></textarea> <br />
        <button class="bg-gray-800 py-2 text-white w-[400px]" type="submit">Add Comment</button>
      </form>
    <?php elseif($user === null): ?>
      <p class="mb-6">
        <a href="/login" class="text-blue-600 text-lg underline underline-offset-1">Login to comment</a>
      </p>
    <?php endif; ?>

    <div class="grid grid-cols-3 gap-6">
      <?php foreach($comments as $comment): ?>
        <div class="bg-white rounded-lg p-6">
          <h3 class="text-xl"><?= $comment->user_name; ?></h3>
          <p><?= nl2br(htmlspecialchars($comment->content)) ?></p>
          <small class="text-gray-400">Posted on: <?= htmlspecialchars($comment->created_at) ?></small>
        </div>
      <?php endforeach; ?>
    </div>
  </section>
</div>
