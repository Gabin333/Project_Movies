<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';

use App\Repository\MovieRepository;
use App\Controller\MovieController;
use App\Repository\AccountRepository;
use App\Controller\RegisterController;

$movieRepo = new MovieRepository($pdo);
$movieController = new MovieController($movieRepo);
$accountRepo = new AccountRepository($pdo);
$registerController = new RegisterController($accountRepo, $movieRepo);

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Handle registration
$messages = [];
if ($uri === '/register') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $messages[] = "Email invalide.";
        } elseif (strlen($password) < 4) {
            $messages[] = "Mot de passe trop court.";
        } else {
            // Vérifie si l'email existe déjà
            $stmt = $pdo->prepare('SELECT id FROM accounts WHERE email = :email');
            $stmt->execute([':email' => $email]);
            if ($stmt->fetch()) {
                $messages[] = "Email déjà utilisé.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO accounts (email, password) VALUES (:email, :password)');
                $stmt->execute([':email' => $email, ':password' => $hash]);
                $lastId = (int)$pdo->lastInsertId();
                $_SESSION['id'] = $lastId;
                header('Location: /');
                exit;
            }
        }
    }
    require __DIR__ . '/../views/template_register.php';
    exit;
}

if ($uri === '/login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $stmt = $pdo->prepare('SELECT id, password FROM accounts WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            header('Location: /');
            exit;
        } else {
            $messages[] = "Email ou mot de passe incorrect.";
        }
    }
    require __DIR__ . '/../views/template_login.php';
    exit;
}

if ($uri === '/logout') {
    session_destroy();
    header('Location: /');
    exit;
}

switch ($uri) {
    case '/movie/add':
    case '/movie/add/':
        echo $movieController->addMovie();
        break;

    case '/movies':
    case '/movies/':
        echo $movieController->showAllMovies();
        break;

    case '/account/movie':
    case '/account/movie/':
        $registerController->addMovieToAccount();
        break;

    case '/account/movie/remove':
    case '/account/movie/remove/':
        $registerController->removeMovieFromAccount();
        break;

    case '/account/movies':
    case '/account/movies/':
        $registerController->showAllMoviesToAccount();
        break;

    case '/account':
    case '/account/':
        $registerController->showAccount();
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

