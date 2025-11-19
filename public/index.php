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

if ($uri === '/movie/add' || $uri === '/movie/add/') {
    $movieController->addMovie();
} elseif ($uri === '/' || $uri === '/index.php') {
    echo '<h1>Accueil</h1><ul><li><a href="/movie/add">Ajouter un film</a></li></ul>';
} else {
    http_response_code(404);
    echo '404 - Page non trouvée';
}
