<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

use App\Repository\MovieRepository;
use App\Controller\MovieController;

$movieRepo = new MovieRepository($pdo);
$movieController = new MovieController($movieRepo);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/movie/add':
    case '/movie/add/':
        echo $movieController->addMovie();
        break;

    case '/movies':
    case '/movies/':
        echo $movieController->showAllMovies();
        break;

    case '/':
    case '/index.php':
        require __DIR__ . '/../views/template_home.php';
        break;

    default:
        http_response_code(404);
        echo '404 - Page non trouvée';
        break;
}

