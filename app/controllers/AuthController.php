<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\Auth;
use Core\Router;
use Core\View;

class AuthController {
  public function register() {
    return View::render('auth/register', [], 'layout/main');
  }

  public function storeRegister() {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password']; 

    $user = User::findByEmail($email);

    if ($user) {
      return View::render('auth/register', ['error' => 'Email already exists'], 'layout/main');
    }

    if ($password !== $confirm_password) {
      return View::render('auth/register', ['error' => 'Password and confirm password don\'t match'], 'layout/main');
    }

    
    $timestamp = date('Y-m-d H:i:s');

    User::create([
      'name' => $name,
      'email' => $email,
      'password' => password_hash($password, PASSWORD_DEFAULT),
      'created_at' => $timestamp
    ]);

    if (Auth::attempt($email, $password)) {
      $currentUser = Auth::user();

      if ($currentUser->role === 'admin') {
        return Router::redirect("/admin/dashboard");
      }

      return Router::redirect("/");
    }

    return View::render('auth/register', ['error' => 'Please fill out all the fields'], 'layout/main');
  }

  public function login() {
    return View::render('auth/login', [], 'layout/main');
  }

  public function storeLogin() {
    $email = $_POST['email'];
    $password = $_POST['password']; 
    // $remember = isset($_POST['remember']) ? (bool) $_POST['remember'] : false;

    if (Auth::attempt($email, $password)) {
      $user = Auth::user();

      if ($user->role === 'admin') {
        return Router::redirect("/admin/home");
      }

      return Router::redirect("/");
    }

    return View::render('auth/login', ['error' => 'Invalid Credentials'], 'layout/main');
  }

  public function destroy() {
    Auth::logout();
    Router::redirect("/login");
  }
}