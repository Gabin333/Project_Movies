<?php
namespace App\Controller;

use App\Repository\MovieRepository;
use App\Model\Movie;

class MovieController {
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    // 🔹 Méthode pour inclure un template
    public function render(string $template, array $data = [])
    {
        extract($data);
        require __DIR__ . '/../../views/' . $template . '.php';
    }

    // 🔹 Ajouter un film
    public function addMovie()
    {
        $messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $duration = (int)($_POST['duration'] ?? 0);
            $cover = trim($_POST['cover'] ?? '');
            $publishAt = $_POST['publish_at'] ?? '';

            if (!$title || !$description || !$duration || !$cover || !$publishAt) {
                $messages[] = 'Tous les champs sont obligatoires';
            } else {
                $movie = new Movie();
                $movie->setTitle($title);
                $movie->setDescription($description);
                $movie->setDuration($duration);
                $movie->setCover($cover);
                $movie->setPublishAt($publishAt);

                $categories = $_POST['categories'] ?? [];
                foreach ($categories as $catId) {
                    $movie->addCategory((int)$catId);
                }

                if ($this->movieRepository->saveMovie($movie)) {
                    $messages[] = 'Film ajouté avec succès !';
                } else {
                    $messages[] = 'Erreur lors de l\'ajout du film';
                }
            }
        }

        $this->render('template_add_movie', ['messages' => $messages]);
    }

    // 🔹 Afficher tous les films
    public function showAllMovies()
    {
        $movies = $this->movieRepository->findAllMovies();
        $this->render('template_all_movie', ['movies' => $movies]);
    }
}

