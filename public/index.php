<?php

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

require __DIR__ . '/../config/db.php';

use App\Repository\MovieRepository;
use App\Controller\MovieController;

$movieRepo = new MovieRepository($pdo);
$movieController = new MovieController($movieRepo);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routing simple
switch ($uri) {
    case '/movie/add':
    case '/movie/add/':
        $movieController->addMovie();
        break;

    case '/movies':
    case '/movies/':
        $movieController->showAllMovies();
        break;

    case '/':
    case '/index.php':
        // Page d'accueil décorée
        require __DIR__ . '/../views/template_home.php';
        break;

    default:
        http_response_code(404);
        echo '404 - Page non trouvée';
        break;
}
