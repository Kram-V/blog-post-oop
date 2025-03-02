<div class="bg-white w-[400px] p-6 rounded-lg mt-10">
  <h2 class="text-center mb-5 text-xl">Login</h2>

  <?php if(isset($error)): ?>
    <p class="text-red-600 text-center"><?= $error; ?></p>
  <?php endif; ?>

  <form action="/login" method="POST" class="flex flex-col gap-4">
    <?= csrf_token(); ?>

    <div> 
      <label for="email">Email</label> <br />
      <input class="border-2 w-full" type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
    </div>
    
    <div>
      <label for="password">Password</label> <br />
      <input class="border-2 w-full" type="password" id="password" name="password" required>
    </div>
    <!-- <div>
      <label for="remember">Remember Me</label>
      <input type="checkbox" id="remember" name="remember">
    </div> -->
    <button class="bg-gray-800 py-2 text-white" type="submit">Submit</button>
  </form>
</div>