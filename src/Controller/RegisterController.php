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
                    $res = $this->accountRepository->saveMovieToAccount($movie, $accountId);
                    if ($res === 1) {
                        $messages[] = "Film ajouté à votre compte !";
                    } elseif ($res === 0) {
                        $messages[] = "Ce film est déjà associé à votre compte.";
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

    /**
     * Handle removing a movie from the current account.
     */
    public function removeMovieFromAccount(): void
    {
        $messages = [];
        $accountId = $_SESSION['id'] ?? null;
        if (!$accountId) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
            $movieId = (int)$_POST['movie_id'];
            if (!$movieId) {
                $messages[] = 'Identifiant de film invalide.';
            } else {
                $removed = $this->accountRepository->removeMovieFromAccount((int)$accountId, $movieId);
                if ($removed) {
                    $messages[] = 'Le film a été retiré de votre compte.';
                } else {
                    $messages[] = 'Le film n\'a pas été trouvé dans votre compte ou une erreur est survenue.';
                }
            }
        }

        $movies = $this->accountRepository->getMoviesForAccount((int)$accountId);
        require __DIR__ . '/../../views/template_account.php';
    }

    /**
     * Show all movies linked to the currently authenticated account.
     * Only available when logged in.
     */
    public function showAllMoviesToAccount(): void
    {
        $accountId = $_SESSION['id'] ?? null;
        if (!$accountId) {
            header('Location: /login');
            exit;
        }

        $data = [];
        $data['movies'] = $this->accountRepository->findAllMoviesToAccount((int)$accountId);

        require __DIR__ . '/../../views/template_show_all_movie_to_account.php';
    }
}
