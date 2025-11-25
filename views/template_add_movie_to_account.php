<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Ajouter un film à mon compte</h1>

            <!-- show any messages (controller sets $messages array) -->
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="alert <?= strpos($msg, 'succ') !== false ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($msg) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- single consistent form (name="movie" matches controller expectation) -->
            <form method="POST">
                <div class="mb-3">
                    <label for="movie" class="form-label">Film</label>
                    <select name="movie" id="movie" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($movies as $m): ?>
                            <option value="<?= (int)$m['id'] ?>"><?= htmlspecialchars($m['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Ajouter</button>
                    <a href="/account" class="btn btn-secondary">Retour au compte</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
