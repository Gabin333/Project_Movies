<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container mt-5">
    <h1 class="mb-4">Ajouter un film</h1>

    <!-- Messages de validation / succès -->
    <?php if (!empty($messages)): ?>
        <div class="mb-4">
            <?php foreach ($messages as $msg): ?>
                <div class="alert <?= strpos($msg, 'succès') !== false ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($msg) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/movie/add" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de publication</label>
            <input type="date" name="publish_at" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Durée (minutes)</label>
            <input type="number" name="duration" class="form-control" value="90" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover (image)</label>
            <input type="file" name="cover" class="form-control">
            <small class="text-muted">Si aucun fichier n'est sélectionné, l'image par défaut sera utilisée.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégories</label>
            <select name="categories[]" class="form-select" multiple>
                <option value="1">Action</option>
                <option value="2">Comédie</option>
                <option value="3">Drame</option>
            </select>
            <small class="text-muted">Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs catégories.</small>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le film</button>
        <a href="/" class="btn btn-secondary">Retour</a>
    </form>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
