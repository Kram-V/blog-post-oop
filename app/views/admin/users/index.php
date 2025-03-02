<div class="w-[1100px] my-10">
  <h2 class="text-2xl mb-6">Manage Users</h2>

  <table class="w-full border border-gray-300 border-collapse">
    <thead>
      <tr class="bg-gray-100 border border-gray-300">
        <th class="text-start w-[850px]">Name</th>
        <th class="text-start w-[950px]">Created At</th>
        <th class="text-start w-[150px]">Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach($users as $user): ?>
        <?php if($user->id !== App\Services\Auth::user()->id): ?>
          <tr class="border border-gray-300">
            <td><?= htmlspecialchars($user->name) ?></td>
            <td><?= htmlspecialchars($user->created_at) ?></td>
            <td class="py-2">
              <?php if($user->role === 'admin'): ?>
                <form action="/admin/users/<?= $user->id ?>/non-admin" method="POST">
                  <?= csrf_token(); ?>

                  <button class="bg-white px-2 rounded-lg" type="submit"> Non-admin</button>
                </form>
              <?php else: ?>
                <form action="/admin/users/<?= $user->id ?>/admin" method="POST">
                  <?= csrf_token(); ?>

                  <button class="bg-white px-2 rounded-lg" type="submit">Admin</button>
                </form>
              <?php endif; ?>
            </td>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>