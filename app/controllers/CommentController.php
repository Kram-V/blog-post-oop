<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Services\Auth;
use App\Services\Authorization;
use Core\Router;

class CommentController {
  public function store($id) {
    Authorization::verify('comment');

    $postId = $id;

    $content = $_POST['content'];

    
  $timestamp = date('Y-m-d H:i:s');

    Comment::create([
      'user_id' => Auth::user()->id,
      'post_id' => $postId,
      'content' => $content,
      'created_at' => $timestamp,
    ]);

    return Router::redirect("/posts/{$postId}#comments");
  }
}