<?php
namespace App\Controller;

use App\Repository\MovieRepository;
use App\Model\Movie;

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $movie = new Movie;
            $movie->setTitle($_POST['title']);
            $movie->setDescription($_POST['description']);
            $movie->setPublishAt(new \DateTime($_POST['publish_at']));
            $movie->setDuration($_POST['duration'] ?? 90);

            if (!empty($_FILES['cover']['name'])) {
                $ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['cover']['tmp_name'], __DIR__ . '/../../public/asset/' . $filename);
                $movie->setCover($filename);
            } else {
                $movie->setCover('default.png');
            }

            $this->movieRepository->saveMovie($movie);

            header('Location: /movies');
            exit;
        }

        require __DIR__ . '/../../views/template_add_movie.php';
    }
}


