<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Ajouter un film</h1>

    <?php if (!empty($messages)): ?>
        <div class="alert alert-info">
            <ul class="mb-0">
                <?php foreach ($messages as $msg): ?>
                    <li><?= htmlspecialchars($msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/movie/add">
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
            <input type="number" name="duration" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover (URL)</label>
            <input type="text" name="cover" class="form-control" required>
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
</div>

</body>
</html>
