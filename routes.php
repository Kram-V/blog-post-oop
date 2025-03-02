<?php

use App\Middlewares\Auth;
use App\Middlewares\CSRF;
use App\Middlewares\Redirect;
use App\Middlewares\UnauthAndNonAdminUser;
use App\Middlewares\View;

$router->addGlobalMiddleware(View::class);
$router->addGlobalMiddleware(CSRF::class);
$router->addRouteMiddleware('auth', Auth::class);
$router->addRouteMiddleware('redirect', Redirect::class);
$router->addRouteMiddleware('unauth_and_non_admin_user', UnauthAndNonAdminUser::class);


/**
 * @var Core\Router $router
 */
$router->add('GET', '/', 'HomeController@index', ['unauth_and_non_admin_user']);

$router->add('GET', '/posts', 'PostController@index', ['unauth_and_non_admin_user']);
$router->add('GET', '/posts/create', 'PostController@create', ['auth']);
$router->add('GET', '/posts/{id}', 'PostController@show');
$router->add('GET', '/posts/{id}/edit', 'PostController@edit', ['auth']);
$router->add('POST', '/posts', 'PostController@store', ['auth']);
$router->add('POST', '/posts/{id}/comments', 'CommentController@store', ['auth']);
$router->add('POST', '/posts/{id}', 'PostController@update', ['auth']);
$router->add('POST', '/posts/{id}/delete', 'PostController@delete', ['auth']);

$router->add('GET', '/login', 'AuthController@login', ['redirect']);
$router->add('GET', '/register', 'AuthController@register', ['redirect']);
$router->add('GET', '/logout', 'AuthController@destroy', ['auth']);
$router->add('POST', '/login', 'AuthController@storeLogin');
$router->add('POST', '/register', 'AuthController@storeRegister');

$router->add('GET', '/admin/home', 'Admin\\DashboardController@index', ['auth']);

$router->add('GET', '/admin/posts', 'Admin\\PostController@index', ['auth']);
$router->add('GET', '/admin/users', 'Admin\\PostController@users', ['auth']);
$router->add('GET', '/admin/posts/{id}/edit', 'Admin\\PostController@edit', ['auth']);
$router->add('POST', '/admin/users/{id}/admin', 'Admin\\PostController@makeUserAdmin', ['auth']);
$router->add('POST', '/admin/users/{id}/non-admin', 'Admin\\PostController@makeUserNonAdmin', ['auth']);
$router->add('POST', '/admin/posts/{id}', 'Admin\\PostController@update', ['auth']);
$router->add('POST', '/admin/posts/{id}/delete', 'Admin\\PostController@delete', ['auth']);
