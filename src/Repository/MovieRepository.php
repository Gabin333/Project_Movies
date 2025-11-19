<?php
namespace App\Repository;

use App\Model\Movie;
use PDO;

class MovieRepository {
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
            $stmtCat = $this->connect->prepare("INSERT INTO movie_category (movie_id, category_id) VALUES (:movie_id, :category_id)");
            foreach ($movie->getCategories() as $catId) {
                $stmtCat->bindValue(':movie_id', $movieId, PDO::PARAM_INT);
                $stmtCat->bindValue(':category_id', $catId, PDO::PARAM_INT);
                $stmtCat->execute();
            }
        }

        return $result;
    }
}
