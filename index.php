<?php
define('ROOT', __DIR__ . '/');
define('APP',  ROOT . 'app/');
define('BASE', $_SERVER['SCRIPT_NAME']); // absolute path e.g. /www/.../index.php

require ROOT . 'config/db.php';
require APP  . 'models/User.php';
require APP  . 'controllers/AuthController.php';
require APP  . 'controllers/UserController.php';

$path     = trim($_SERVER['PATH_INFO'] ?? '', '/');
$segments = array_values(array_filter(explode('/', $path)));
$route    = $segments[0] ?? 'login';

switch ($route) {
    case '':
    case 'login':
        (new AuthController())->login();
        break;
    case 'register':
        (new AuthController())->register();
        break;
    case 'logout':
        (new AuthController())->logout();
        break;
    case 'members':
        $action = $segments[1] ?? '';
        $id     = isset($segments[2]) ? (int)$segments[2] : null;
        $ctrl   = new UserController();
        if ($action === 'modify' && $id) {
            $ctrl->modify($id);
        } elseif ($action === 'delete' && $id) {
            $ctrl->delete($id);
        } else {
            $ctrl->index();
        }
        break;
    default:
        http_response_code(404);
        echo '<h1>404 - Page Not Found</h1><a href="index.php/login/">Go to Login</a>';
}