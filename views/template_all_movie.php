<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-5">
    <h1 class="mb-4">Liste des films</h1>

    <a href="/" class="btn btn-secondary mb-4">Retour à l'accueil</a>
    <a href="/movie/add" class="btn btn-primary mb-4">Ajouter un film</a>

    <div class="row">
        <?php if (!empty($movies)): ?>
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <?php if (!empty($movie['cover'])): ?>
                            <img src="/asset/<?= htmlspecialchars($movie['cover']) ?>" class="card-img-top" alt="<?= htmlspecialchars($movie['title']) ?>" style="max-height:200px;object-fit:cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($movie['description']) ?></p>
                            <p class="text-muted small">Catégories: <?= htmlspecialchars($movie['categories']) ?: 'Aucune' ?> — Durée: <?= htmlspecialchars($movie['duration']) ?> min</p>
                            <p class="publish"><small class="text-muted">Publié le : <?= (new DateTime($movie['publish_at']))->format('d/m/Y') ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info">Aucun film trouvé.</div>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
