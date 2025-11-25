<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <div class="row">
        <div class="col-md-8">
            <h1 class="mb-3">Mon compte</h1>
            <p>Bienvenue sur la page de votre compte.</p>

            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="alert <?= strpos($msg, 'retir') !== false || strpos($msg, 'ajout') !== false ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($msg) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <h2 class="mt-4">Mes films</h2>
            <?php if (empty($movies)): ?>
                <div class="alert alert-info">Vous n'avez pas encore ajouté de film à votre compte.</div>
            <?php else: ?>
                <ul class="list-group">
                    <?php foreach ($movies as $m): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <?= htmlspecialchars($m['title']) ?>
                                <?php if (!empty($m['duration'])): ?>
                                    <small class="text-muted"> — <?= (int)$m['duration'] ?> min</small>
                                <?php endif; ?>
                            </div>
                            <form method="POST" action="/account/movie/remove" style="margin:0;">
                                <input type="hidden" name="movie_id" value="<?= (int)$m['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger">Retirer</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="mt-3">
                <a href="/account/movie" class="btn btn-primary">Ajouter un film</a>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
