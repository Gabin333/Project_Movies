<?php
$isLogged = isset($_SESSION['id']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Movie Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .site-header { background:#0d6efd; color:#fff; }
        .site-header a { color: #fff; text-decoration: none; }
    </style>
</head>
<body>
<header class="site-header py-3 mb-4">
    <div class="container d-flex flex-wrap align-items-center justify-content-between">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <h4 class="m-0">Movie Project</h4>
        </a>
        <nav class="nav">
            <a class="nav-link text-white" href="/">Accueil</a>
            <a class="nav-link text-white" href="/movies">Tous les films</a>
            <a class="nav-link text-white" href="/movie/add">Ajouter un film</a>
            <?php if ($isLogged): ?>
                <a class="nav-link text-white" href="/account">Mon compte</a>
                <a class="nav-link text-white" href="/account/movie">Ajouter à mon compte</a>
                <a class="nav-link text-white" href="/logout">Déconnexion</a>
            <?php else: ?>
                <a class="nav-link text-white" href="/login">Se connecter</a>
                <a class="nav-link text-white" href="/register">S'inscrire</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
