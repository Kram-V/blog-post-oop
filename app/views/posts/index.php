<div class="w-[1100px] my-10">
  <div class="flex justify-between">
    <div>
      <h2 class="text-2xl">All Posts</h2>
    </div>

    <form action="/posts" method="GET">
      <input class="py-1 px-2 relative left-1" type="text" name="search" value="<?= $search; ?>" placeholder="Search">
      <button class="bg-gray-800 px-4 text-white py-1">Search</button>
    </form>

    <?php if($user && $user->role === 'non-admin'): ?>
      <a class="bg-white px-4 py-1 rounded-lg" href="/posts/create">Create Post</a>
    <?php endif; ?>
  </div>


  <?php if(count($posts) > 0): ?>
    <div class="grid grid-cols-3 mt-10 mb-10 gap-10">
      <?php foreach($posts as $post): ?>
        <article class="bg-white rounded-lg p-6">
          <div style="display: flex; justify-content: space-between; gap: 20px">
            <h3 class="text-lg font-medium mb-4 underline underline-offset-1">
              <a href="posts/<?= $post->id; ?>"><?= e($post->title); ?></a>
            </h3>
          </div>

          <div>
            <?php if(strlen($post->content) >= 100): ?>
              <p><?= e(substr($post->content, 0, 100)); ?>...</p> 
            <?php else: ?>
              <p><?= e($post->content); ?></p> 
            <?php endif; ?>

            <?php if($user && $user->id === $post->user_id): ?>
              <div class="flex justify-center gap-1 mt-4">
                <a class="bg-gray-600 px-4 py-1 rounded-lg text-white" href="posts/<?= $post->id ?>/edit">Edit</a>
                <form action="posts/<?= $post->id ?>/delete" method="POST">
                  <?= csrf_token(); ?>
                  <button class="bg-red-600 px-4 py-1 rounded-lg text-white" type="submit">Delete</button>
                </form>
              </div>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if($totalPages > 1): ?>
      <div class="flex justify-between items-center">
        <select id="perPage" name="perPage" class="w-[60px] rounded-md py-1">
          <option value="5" <?php echo isset($_GET['perPage']) && $_GET['perPage'] == 5 ? 'selected' : ''; ?>>5</option>
          <option value="10" <?php echo isset($_GET['perPage']) && $_GET['perPage'] == 10 ? 'selected' : ''; ?>>10</option>
          <option value="15" <?php echo isset($_GET['perPage']) && $_GET['perPage'] == 15 ? 'selected' : ''; ?>>15</option>
        </select>

        <div class="pagination-2 text-white font-medium">
          Showing <?php echo $count > 0 ? $startIndex : 0; ?> to <?php echo $endIndex; ?> of <?php echo $count; ?> results
        </div>


        <div>
          <div class="flex gap-3">
            <div>
              <a href="posts?<?= http_build_query(['page' => isset($_GET['page']) ? (int) $_GET['page'] - 1 : 1,  'search' => $search, 'perPage' => $perPage]) ?>">
                <button class="bg-white px-4 py-1 rounded-lg <?= $currentPage <= 1 ? 'cursor-not-allowed' : '' ?>"  <?= $currentPage <= 1 ? 'disabled' : ''  ?>>
                  Prev
                </button>
              </a>
            </div>
            <div>
              <a href="posts?<?= http_build_query(['page' => isset($_GET['page']) ? (int) $_GET['page'] + 1 : 1,  'search' => $search, 'perPage' => $perPage]) ?>">
              <button class="bg-white px-4 py-1 rounded-lg <?= $currentPage >= $totalPages ? 'cursor-not-allowed' : '' ?>"  <?= $currentPage >= $totalPages ? 'disabled' : ''  ?>>
                  Next
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <script>
        document.getElementById('perPage').addEventListener('change', function() {
          let url = new URL(window.location.href);
          url.searchParams.set('perPage', this.value);
          url.searchParams.set('page', 1);
          url.searchParams.set('search', '');
          window.location.href = url.toString();
        });
      </script>
    <?php endif; ?>
  <?php else: ?>
    <h2 class="text-center mt-24 text-3xl">NO POSTS</h2>
  <?php endif; ?>
</div>