<?php
namespace App\Repository;

use PDO;
use App\Model\Movie;

class MovieRepository
{
    private PDO $connect;

    public function __construct(PDO $connect)
    {
        $this->connect = $connect;
    }

    public function saveMovie(Movie $movie): bool
    {
        $sql = "INSERT INTO movies (title, description, publish_at, duration, cover)
                VALUES (:title, :description, :publish_at, :duration, :cover)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':title', $movie->getTitle());
        $stmt->bindValue(':description', $movie->getDescription());
        $stmt->bindValue(':publish_at', $movie->getPublishAt()->format('Y-m-d H:i:s'));
        $stmt->bindValue(':duration', $movie->getDuration(), PDO::PARAM_INT);
        $stmt->bindValue(':cover', $movie->getCover());
        $result = $stmt->execute();

        if ($result && !empty($movie->getCategories())) {
            $movieId = $this->connect->lastInsertId();
            $stmtCat = $this->connect->prepare(
                "INSERT INTO movie_category (movie_id, category_id) VALUES (:movie_id, :category_id)"
            );

            foreach ($movie->getCategories() as $catId) {
                $stmtCat->bindValue(':movie_id', $movieId);
                $stmtCat->bindValue(':category_id', $catId);
                $stmtCat->execute();
            }
        }

        return $result;
    }

    public function findAllMovies(): array
    {
        $sql = "SELECT m.id, m.title, m.description, m.publish_at, m.duration, m.cover,
                       GROUP_CONCAT(c.name SEPARATOR ', ') AS categories
                FROM movies m
                LEFT JOIN movie_category mc ON m.id = mc.movie_id
                LEFT JOIN categories c ON mc.category_id = c.id
                GROUP BY m.id";
        return $this->connect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
