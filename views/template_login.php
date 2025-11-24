<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Connexion</h1>

            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button class="btn btn-primary">Se connecter</button>
                <a href="/register" class="btn btn-link">S'inscrire</a>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
