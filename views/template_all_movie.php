<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tous les films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">Liste des films</h1>

    <a href="/" class="btn btn-secondary mb-3">Retour Accueil</a>

    <div class="row">
        <?php foreach ($movies as $movie): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="/assets/<?= htmlspecialchars($movie['cover']) ?>" class="card-img-top" style="height:250px; object-fit:cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                        <p><strong>Publié :</strong> <?= htmlspecialchars($movie['publish_at']) ?></p>
                        <p><strong>Durée :</strong> <?= htmlspecialchars($movie['duration']) ?> min</p>
                        <p><strong>Catégories :</strong> <?= htmlspecialchars($movie['categories']) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
