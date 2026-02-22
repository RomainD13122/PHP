<?php
session_start();

// Expiration session après 20 min d'inactivité
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) {
    session_unset();
    session_destroy();
    header('Location: /login?msg=Session+expir%C3%A9e');
    exit;
}
if (isset($_SESSION['user_id'])) {
    $_SESSION['last_activity'] = time();
}

define('ROOT', dirname(__DIR__));

require_once ROOT . '/src/config/Database.php';
require_once ROOT . '/src/controllers/BaseController.php';

spl_autoload_register(function($class) {
    $file = ROOT . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) require $file;
});

// Routes
$routes = [
    ''                  => ['MovieController', 'list'],
    'login'             => ['AuthController', 'login'],
    'register'          => ['AuthController', 'register'],
    'logout'            => ['AuthController', 'logout'],
    'profile'           => ['AuthController', 'profile'],
    'movie/([0-9]+)'    => ['MovieController', 'detail'],
    'book/([0-9]+)'     => ['BookingController', 'form'],
    'my-bookings'       => ['BookingController', 'my'],
    'admin/movies'      => ['AdminController', 'movies'],
    'admin/movies/add'  => ['AdminController', 'addMovie'],
    'admin/movies/edit/([0-9]+)' => ['AdminController', 'editMovie'],
    'admin/movies/del/([0-9]+)'  => ['AdminController', 'delMovie'],
    'admin/showtimes/([0-9]+)' => ['AdminController', 'showtimes'],
    'admin/showtimes/add/([0-9]+)' => ['AdminController', 'addShowtime'],
];

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$matched = false;

foreach ($routes as $pattern => $handler) {
    if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
        array_shift($matches);
        [$ctrl, $method] = $handler;
        $controller = new ("controllers\\$ctrl")();
        call_user_func_array([$controller, $method], $matches);
        $matched = true;
        break;
    }
}

if (!$matched) {
    http_response_code(404);
    $controller = new controllers\MovieController();
    $controller->show404('Page non trouvée');
    exit;
}