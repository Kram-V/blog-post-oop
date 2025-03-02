<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>My Blog</title>
  </head>
  <body class="bg-gray-400">
    <div class="bg-gray-800 text-white">
      <nav class="h-full py-5 w-[1100px] mx-auto flex justify-between gap-16"> 
        <a href="/">Blog Post App</a>

        <div class="flex gap-10">
          <a href="/">Home</a>
          <a href="/posts">Posts</a>
          <?php if($user): ?>
            <a href="/logout">Logout</a>
          <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
          <?php endif; ?>
        </div>
      </nav>
    </div>
    <main class="flex justify-center">
      <?= $content ?> 
    </main>
    <!-- <footer>
      <p>&copy; <?=date('Y')?> My Blog</p>
    </footer> -->
    
    <script src="https://cdn.tailwindcss.com"></script>
  </body>
</html>