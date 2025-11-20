<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Movies Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .hero {
            background: #0d6efd;
            color: white;
            padding: 50px 0;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 0 0 20px 20px;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="hero">
    <h1>Bienvenue sur Movies Project</h1>
    <p>Ajoutez et consultez vos films facilement !</p>
</div>

<div class="container">
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card card-hover">
                <div class="card-body text-center">
                    <h5 class="card-title">Ajouter un film</h5>
                    <p class="card-text">Remplissez le formulaire pour ajouter un nouveau film dans la base.</p>
                    <a href="/movie/add" class="btn btn-primary">Ajouter un film</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-hover">
                <div class="card-body text-center">
                    <h5 class="card-title">Voir tous les films</h5>
                    <p class="card-text">Consultez la liste complète de tous les films ajoutés.</p>
                    <a href="/movies" class="btn btn-success">Voir la liste</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
