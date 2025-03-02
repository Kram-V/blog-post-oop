<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Core\App;

require_once __DIR__ . '/../bootstrap.php';

$timestamp = date('Y-m-d H:i:s');

$users = [
    ['name' => 'Admin User', 'email' => 'admin@example.com', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin', 'created_at' => $timestamp],
    ['name' => 'John Doe', 'email' => 'john@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'non-admin', 'created_at' => $timestamp],
    ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'role' => 'non-admin', 'created_at' => $timestamp],
];

$posts = [
    ['user_id' => 1, 'title' => 'How to Optimize Your Vue.js App for Better Performance', 'content' => 'Learn essential tips for improving your Vue.js application\'s performance, from lazy loading components to optimizing reactivity and reducing unnecessary re-renders.', 'created_at' => $timestamp],
    ['user_id' => 2, 'title' => 'Building a Scalable CMS with Laravel and Vue.js', 'content' => 'A step-by-step guide on integrating Laravel with Vue.js to build a powerful and scalable content management system (CMS). Covers API development, authentication, and UI best practices.', 'created_at' => $timestamp],
    ['user_id' => 3, 'title' => 'Deploying a Vue.js and Laravel App on AWS: A Complete Guide', 'content' => 'A detailed tutorial on hosting your Vue.js frontend and Laravel backend on AWS, including setting up EC2, RDS, and S3, and using Vercel for frontend deployment.', 'created_at' => $timestamp],
    ['user_id' => 4, 'title' => 'Creating Dynamic and Interactive Data Tables in Vue 3', 'content' => 'Learn how to use vue-good-table and other libraries to create interactive tables with sorting, filtering, and pagination in your Vue.js projects.', 'created_at' => $timestamp],
    ['user_id' => 5, 'title' => 'Mastering React Hook Form with MUI for Seamless Form Handling', 'content' => 'Explore best practices for handling complex forms in React using React Hook Form and Material-UI, including validation, dynamic fields, and state management.', 'created_at' => $timestamp],
    ['user_id' => 6, 'title' => 'Using Redux Toolkit and Zustand for Efficient State Management in React', 'content' => 'Compare Redux Toolkit and Zustand for managing state in large-scale React applications. Learn when to use each approach and how to implement them effectively.', 'created_at' => $timestamp],
    ['user_id' => 7, 'title' => 'Enhancing User Experience with Lazy Loading in React and Vue.', 'content' => 'Discover how to implement lazy loading in both React and Vue.js to improve app performance and optimize resource loading.', 'created_at' => $timestamp],
    ['user_id' => 8, 'title' => 'Generating PDFs in a Vue.js or React App: A Complete Guide', 'content' => ' Learn how to create and customize PDF generation in Vue.js and React using libraries like jsPDF, Puppeteer, and react-to-pdf.', 'created_at' => $timestamp],
    ['user_id' => 9, 'title' => 'Building a Drag-and-Drop Interface in Vue.js with vue-draggable-resizable', 'content' => 'Step-by-step instructions for implementing a drag-and-drop UI in Vue.js using the vue-draggable-resizable library, perfect for dashboards and interactive elements.', 'created_at' => $timestamp],
    ['user_id' => 10, 'title' => 'Server-Side Pagination in a Vue 3 App with Laravel', 'content' => 'A guide on implementing server-side pagination in a Vue.js app using Laravel as the backend, ensuring efficient data fetching and performance optimization.', 'created_at' => $timestamp],
    ['user_id' => 11, 'title' => 'State Management in Vue.js 3: Pinia vs Vuex', 'content' => 'Learn the key differences between Pinia and Vuex for managing state in Vue 3 applications. This post explores their features, setup, and best use cases, helping you choose the right tool for your project.', 'created_at' => $timestamp],
];

$comments = [
    ['post_id' => 1, 'user_id' => 2, 'content' => 'Great first post! Looking forward to more.', 'created_at' => $timestamp],
    ['post_id' => 1, 'user_id' => 3, 'content' => 'Welcome to the blogosphere!', 'created_at' => $timestamp],
    ['post_id' => 2, 'user_id' => 1, 'content' => 'These are some really useful tips, thanks!', 'created_at' => $timestamp],
    ['post_id' => 3, 'user_id' => 2, 'content' => 'I\'ve been using these practices and they really help.', 'created_at' => $timestamp],
];

$db = App::get('database');

$db->query("DELETE FROM comments");
$db->query("DELETE FROM users");
$db->query("DELETE FROM posts");
// $db->query("DELETE FROM remember_tokens");

$db->query("DELETE FROM sqlite_sequence WHERE name IN ('users', 'posts', 'comments')");


foreach($users as $user) {
  User::create($user);
}

foreach($posts as $post) {
  Post::create($post);
}

foreach($comments as $comment) {
  Comment::create($comment);
}

echo "Data Loaded Successfully!";