<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard</title>
  </head>
  <body class="bg-gray-400">
    <div class="bg-gray-800 text-white">
      <nav class="h-full py-5 w-[1100px] mx-auto flex justify-between gap-16"> 
        <a href="/admin/home">Blog Post App</a>
        
        <div class="flex gap-10">
          <a href="/admin/home">Dashboard</a>
          <a href="/admin/posts">Manage Posts</a>
          <a href="/admin/users">Manage Users</a> 
          <a href="/logout">Logout</a>
        </div>
      </nav>
    </div>
    <main class="flex justify-center">
      <?= $content ?> 
    </main>

    <script src="https://cdn.tailwindcss.com"></script>
  </body>
</html>