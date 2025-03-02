<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\Auth;
use App\Services\Authorization;
use Core\Router;
use Core\View;

class PostController {
  public function index(){
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $page = isset($_GET['page']) && $_GET['page'] >= 1 ? $_GET['page'] : 1; 
    $limit = $_GET['perPage'] ?? 5;

    $posts = Post::all($search, $limit, $page);
    $total = Post::count($search); 

    $startIndex = ($page - 1) * $limit + 1;
    $endIndex = min($page * $limit, $total);

    $perPage = ceil($total / $limit);

    if (!isset($_GET['page']) || $_GET['page'] < 1) {
      $_GET['page'] = 1;
      header("Location: " . strtok($_SERVER["REQUEST_URI"], '?') . "?page=1&search={$search}&perPage={$limit}");
      exit;
    }

    
    if ($page > $perPage && $total !== 0) {
      header("Location: posts?page=" . $perPage . "&search={$search}&perPage={$limit}");
      exit;
    }


    return View::render(  
      template: 'posts/index', 
      data: [
        'posts' => $posts, 
        'search' => $search, 
        'currentPage' => $page, 
        'totalPages' => ceil($total / $limit), 
        'startIndex' => $startIndex, 
        'endIndex' => $endIndex,
        'count' => $total,
        'perPage' => $limit
      ], 
      layout: 'layout/main'); 
  }

  public function create() {
    Authorization::verify('show_create_post_page');

    return View::render('posts/create', [], 'layout/main');
  }

  public function show($id) {
    $post = Post::find($id);

    if (!$post) {
      Router::notFound();
    }

    $comments = Comment::getCommentsByPostId($id);

  
    $user = Auth::user();

    if ($user !== null) {
      if ($user->role === 'admin') {
        return View::render("posts/show", ['post' => $post, 'comments' => $comments], 'layout/admin');
      } else {
        return View::render("posts/show", ['post' => $post, 'comments' => $comments], 'layout/main');
      }
    }
   
    return View::render("posts/show", ['post' => $post, 'comments' => $comments], 'layout/main');
  }

  public function store() {
    Authorization::verify('create_post');

    
    $timestamp = date('Y-m-d H:i:s');

    $data = [
      'title' => $_POST['title'],
      'content' => $_POST['content'],
      'user_id' => Auth::user()->id, 
      'created_at' => $timestamp,
    ];

    Post::create($data);
    Router::redirect("/posts");
  }

  public function edit($id) {
    $post = Post::find($id);
  
    if (!$post) {
      Router::notFound();
    }

    Authorization::verify('edit_post', $post);

    return View::render('posts/edit', ['post' => $post], 'layout/main');
  }

  public function update($id) {
    $post = Post::find($id);

    if (!$post) {
      Router::notFound();
    }

    Authorization::verify('update_post', $post);

    $post->title = $_POST['title'];
    $post->content = $_POST['content'];
    $post->save();  

    Router::redirect("/posts");
  }

  public function delete($id) {
    $post = Post::find($id);

    if (!$post) {
      Router::notFound();
    }

    Authorization::verify('delete_post', $post);

    $post->delete();

    Router::redirect('/posts');
  }
}