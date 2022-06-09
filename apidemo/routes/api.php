<?php
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\用户控制器;

Route::any('user/register', [用户控制器::class, '注册']);
Route::any('user/login', [用户控制器::class, '登录']);
Route::middleware(['auth:sanctum'])->group(function (Router $router) {
    $router->any('user/logout', [用户控制器::class, '退出登录']);
    $router->any('user/info', [用户控制器::class, '用户信息']);
});
