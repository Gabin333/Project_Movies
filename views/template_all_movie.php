<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .movie-card {
            margin-bottom: 20px;
        }
        .movie-cover {
            max-height: 200px;
            object-fit: cover;
        }
        .movie-info {
            padding: 10px;
        }
        .categories {
            font-size: 0.9rem;
            color: #555;
        }
        .duration {
            font-size: 0.9rem;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Liste des films</h1>

    <a href="/" class="btn btn-secondary mb-4">Retour à l'accueil</a>
    <a href="/movie/add" class="btn btn-primary mb-4">Ajouter un film</a>

    <div class="row">
        <?php if (!empty($movies)): ?>
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4">
                    <div class="card movie-card">
                        <img src="/public/asset/<?= htmlspecialchars($movie['cover']) ?>" class="card-img-top movie-cover" alt="<?= htmlspecialchars($movie['title']) ?>">
                        <div class="card-body movie-info">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                            <p class="categories"><strong>Catégories :</strong> <?= htmlspecialchars($movie['categories']) ?: 'Aucune' ?></p>
                            <p class="duration"><strong>Durée :</strong> <?= htmlspecialchars($movie['duration']) ?> min</p>
                            <p class="publish"><strong>Publié le :</strong> <?= (new DateTime($movie['publish_at']))->format('d/m/Y') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun film trouvé.</p>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
