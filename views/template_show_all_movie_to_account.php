<?php
// Minimal template showing only the required fields for the exercise
$movies = $data['movies'] ?? [];
?>

<h1>Liste des films liés à votre compte</h1>

<?php if (empty($movies)): ?>
    <p>Aucun film associé.</p>
<?php else: ?>
    <ul>
        <?php foreach ($movies as $m): ?>
            <li>
                <strong><?= htmlspecialchars($m['title']) ?></strong><br>
                <?= nl2br(htmlspecialchars($m['description'])) ?><br>
                Publié le : <?= htmlspecialchars($m['publish_at']) ?><br>
                <?php if (!empty($m['cover'])): ?>Couverture : <?= htmlspecialchars($m['cover']) ?><?php endif; ?>
            </li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
