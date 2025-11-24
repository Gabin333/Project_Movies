<?php require __DIR__ . '/partials/header.php'; ?>

<main class="container">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bienvenue sur Movie Project</h1>
            <p class="col-md-8 fs-4">Ajoutez vos films, gérez votre collection et parcourez la liste des films.</p>
            <div class="mt-4">
                <a class="btn btn-primary btn-lg me-2" href="/movie/add">Ajouter un film</a>
                <a class="btn btn-outline-secondary btn-lg me-2" href="/movies">Voir tous les films</a>
                <?php if (isset($_SESSION['id'])): ?>
                    <a class="btn btn-warning btn-lg me-2" href="/account/movie">Ajouter à mon compte</a>
                    <a class="btn btn-danger btn-lg" href="/logout">Déconnexion</a>
                <?php else: ?>
                    <a class="btn btn-success btn-lg" href="/login">Se connecter</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Ajouter un film</h5>
                    <p class="card-text">Formulaire pour ajouter un film avec titre, description, durée et image de couverture.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Afficher les films</h5>
                    <p class="card-text">Liste complète des films ajoutés avec détails et catégories.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Mon compte</h5>
                    <p class="card-text">Gérer votre collection personnelle et les films ajoutés.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
