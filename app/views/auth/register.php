<div class="bg-white w-[400px] p-6 rounded-lg mt-10">
  <h2 class="text-center mb-5 text-xl">Register</h2>

  <?php if(isset($error)): ?>
    <p class="text-red-600 text-center"><?= $error; ?></p>
  <?php endif; ?>

  <form action="/register" method="POST" class="flex flex-col gap-4">
    <?= csrf_token(); ?>

    <div>
      <label for="name">Name</label> <br />
      <input class="border-2 w-full" type="name" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" required>
    </div>

    <div>
      <label for="email">Email</label> <br />
      <input class="border-2 w-full"  type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
    </div>

    <div>
      <label for="password">Password</label> <br />
      <input class="border-2 w-full"  type="password" id="password" name="password" required>
    </div>
    
    <div>
      <label for="confirm_password">Confirm Password</label> <br />
      <input class="border-2 w-full"  type="password" id="confirm_password" name="confirm_password" required>
    </div>

    <button class="bg-gray-800 py-2 text-white" type="submit">Submit</button>
  </form>
</div>