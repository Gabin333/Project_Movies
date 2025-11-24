<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un film à mon compte</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 32px; }
        .flash { padding: 10px; border-radius: 4px; margin: 12px 0; }
        .success { background: #e0f3e0; border: 1px solid #9ce29c; }
        .error { background: #fbe0e0; border: 1px solid #f09a9a; }
    </style>
</head>
<body>
    <h1>Ajouter un film à mon compte</h1>

    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
            <div class="flash error"><?= htmlspecialchars($msg) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>

    <form method="POST">
        <label for="movie">Choisir un film :</label>
        <select name="movie" id="movie" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach ($movies as $movie): ?>
                <option value="<?= htmlspecialchars($movie['id']) ?>">
                    <?= htmlspecialchars($movie['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <input type="submit" name="submit" value="Ajouter">
    </form>
</body>
<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4">Ajouter un film à mon compte</h1>

            <?php if (!empty($message)): ?>
                <div class="alert <?= strpos($message, 'succ') !== false ? 'alert-success' : 'alert-danger' ?>"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="movie_id" class="form-label">Film</label>
                    <select name="movie_id" id="movie_id" class="form-select">
                        <?php foreach ($movies as $m): ?>
                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['title']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button class="btn btn-primary">Ajouter</button>
                <a href="/account" class="btn btn-link">Retour au compte</a>
            </form>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
