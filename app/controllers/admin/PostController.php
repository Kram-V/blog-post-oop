<?php

namespace App\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Services\Authorization;
use Core\Router;
use Core\View;

class PostController {
  public function index() {
    Authorization::verify('all_posts_admin_role');

    $posts = Post::all();

    return View::render('admin/posts/index', ['posts' => $posts], 'layout/admin');
  }

  public function users() {
    Authorization::verify('get_users_admin_role');

    $users = User::all();

    return View::render('admin/users/index', ['users' => $users], 'layout/admin');
  }

  public function edit($id) {
    Authorization::verify('edit_admin_role');

    $post = Post::find($id);
  
    if (!$post) {
      Router::notFound();
    }

    return View::render('admin/posts/edit', ['post' => $post], 'layout/admin');
  }

  public function update($id) {
    Authorization::verify('update_admin_role');

    $post = Post::find($id);

    if (!$post) {
      Router::notFound();
    }

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->save();  

    Router::redirect("/admin/posts");
  }

  public function delete($id) {
    Authorization::verify('delete_post_admin_role');

    $post = Post::find($id);

    if (!$post) {
      Router::notFound();
    }

    $post->delete();

    Router::redirect('/admin/posts');
  }


  public function makeUserAdmin($id) {
    Authorization::verify('make_user_admin');

    $user = User::find($id);

    if (!$user) {
      Router::notFound();
    }

    $user->role = 'admin';
    $user->save();  

    Router::redirect("/admin/users");
  }

  public function makeUserNonAdmin($id) {
    Authorization::verify('make_user_nonadmin');

    $user = User::find($id);

    if (!$user) {
      Router::notFound();
    }

    $user->role = 'non-admin';
    $user->save();  

    Router::redirect("/admin/users");
  }
}