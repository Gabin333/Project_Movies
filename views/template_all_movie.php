<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Liste des films</h1>

    <a href="/movie/add" class="btn btn-primary mb-3">Ajouter un film</a>
    <a href="/" class="btn btn-secondary mb-3">Accueil</a>

    <?php if (empty($movies)): ?>
        <p>Aucun film trouvé.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($movie['cover'])): ?>
                            <img src="<?= htmlspecialchars($movie['cover']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($movie['description'])) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Publié le : <?= htmlspecialchars(date('d/m/Y', strtotime($movie['publish_at']))) ?><br>
                                    Durée : <?= htmlspecialchars($movie['duration']) ?> min<br>
                                    Catégories : <?= htmlspecialchars($movie['categories'] ?? 'Aucune') ?>
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
