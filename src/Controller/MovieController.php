<?php
namespace App\Controller;

use App\Repository\MovieRepository;
use App\Model\Movie;
use Mithridatem\Validation\Exception\ValidationException;

class MovieController
{
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function showAllMovies()
    {
        $movies = $this->movieRepository->findAllMovies();
        require __DIR__ . '/../../views/template_all_movie.php';
    }

    public function addMovie()
    {
        $messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $movie = new Movie();
            $movie->setTitle(trim($_POST['title'] ?? ''));
            $movie->setDescription(trim($_POST['description'] ?? ''));
            $movie->setPublishAt(new \DateTime($_POST['publish_at'] ?? 'now'));
            $movie->setDuration((int)($_POST['duration'] ?? 90));

            // Gestion image
            if (!empty($_FILES['cover']['name'])) {
                $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['cover']['tmp_name'], __DIR__ . '/../../public/asset/' . $filename);
                $movie->setCover($filename);
            } else {
                $movie->setCover('default.png');
            }

            // Validation
            try {
                $movie->validate();
                if ($this->movieRepository->saveMovie($movie)) {
                    $messages[] = 'Film ajouté avec succès !';
                } else {
                    $messages[] = 'Erreur lors de l\'ajout du film';
                }
            } catch (ValidationException $e) {
                // The package throws a ValidationException with a message for the first violation.
                // Append the message so the view can display it.
                $messages[] = $e->getMessage();
            }
        }

        require __DIR__ . '/../../views/template_add_movie.php';
    }
}
