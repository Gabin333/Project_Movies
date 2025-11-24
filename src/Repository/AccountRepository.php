<?php
namespace App\Repository;

use PDO;
use App\Model\Movie;

class AccountRepository
{
    private PDO $connect;

    public function __construct(PDO $connect)
    {
        $this->connect = $connect;
        $this->init();
    }

    private function init(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS account_movie (
            account_id INT UNSIGNED NOT NULL,
            movie_id INT UNSIGNED NOT NULL,
            PRIMARY KEY (account_id, movie_id),
            CONSTRAINT fk_account FOREIGN KEY (account_id) REFERENCES accounts(id) ON DELETE CASCADE,
            CONSTRAINT fk_movie FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $this->connect->exec($sql);
    }

    // ...existing code...
    public function saveMovieToAccount(Movie $movie, int $accountId): bool
    {
        $sql = "INSERT INTO account_movie (account_id, movie_id) VALUES (:account_id, :movie_id)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->bindValue(':movie_id', $movie->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getMoviesForAccount(int $accountId): array
    {
        $sql = "SELECT m.id, m.title, m.description, m.publish_at, m.duration, m.cover
                FROM movies m
                INNER JOIN account_movie am ON m.id = am.movie_id
                WHERE am.account_id = :account_id
                ORDER BY m.title ASC";

        $stmt = $this->connect->prepare($sql);
        $stmt->execute([':account_id' => $accountId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
