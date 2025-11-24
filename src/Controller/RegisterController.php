<?php
namespace App\Controller;

use App\Repository\AccountRepository;
use App\Repository\MovieRepository;
use App\Model\Movie;

class RegisterController
{
    private AccountRepository $accountRepository;
    private MovieRepository $movieRepository;

    public function __construct(AccountRepository $accountRepository, MovieRepository $movieRepository)
    {
        $this->accountRepository = $accountRepository;
        $this->movieRepository = $movieRepository;
    }

    // ...existing code...
    public function addMovieToAccount(): void
    {
        $messages = [];
        $movies = $this->movieRepository->findAllMovies();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie'])) {
            $accountId = $_SESSION['id'] ?? null;
            $movieId = (int)$_POST['movie'];

            if (!$accountId) {
                $messages[] = "Vous devez être connecté.";
            } elseif (!$movieId) {
                $messages[] = "Veuillez sélectionner un film.";
            } else {
                $movie = new Movie();
                $movie->setId($movieId);
                if ($this->accountRepository->saveMovieToAccount($movie, $accountId)) {
                    $messages[] = "Film ajouté à votre compte !";
                } else {
                    $messages[] = "Erreur lors de l'ajout du film à votre compte.";
                }
            }
        }

        require __DIR__ . '/../../views/template_add_movie_to_account.php';
    }

    public function showAccount(): void
    {
        $messages = [];
        $accountId = $_SESSION['id'] ?? null;
        if (!$accountId) {
            header('Location: /login');
            exit;
        }

        $movies = $this->accountRepository->getMoviesForAccount((int)$accountId);
        require __DIR__ . '/../../views/template_account.php';
    }
}
