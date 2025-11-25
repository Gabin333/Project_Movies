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
    /**
     * Save a movie for an account.
     * Return codes:
     *  1 = inserted
     *  0 = already exists (no-op)
     * -1 = error
     */
    public function saveMovieToAccount(Movie $movie, int $accountId): int
    {
        // check whether the association already exists
        $checkSql = 'SELECT 1 FROM account_movie WHERE account_id = :account_id AND movie_id = :movie_id LIMIT 1';
        $checkStmt = $this->connect->prepare($checkSql);
        $checkStmt->execute([
            ':account_id' => $accountId,
            ':movie_id' => $movie->getId()
        ]);

        if ($checkStmt->fetchColumn()) {
            // already linked
            return 0;
        }

        $sql = "INSERT INTO account_movie (account_id, movie_id) VALUES (:account_id, :movie_id)";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->bindValue(':movie_id', $movie->getId(), PDO::PARAM_INT);

        try {
            return $stmt->execute() ? 1 : -1;
        } catch (\PDOException $e) {
            // log or ignore and report error status
            return -1;
        }
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

    /**
     * Find all movies linked to a given account ID.
     * Returns an array of associative arrays containing
     * title, description, publish_at and cover.
     *
     * @param int $accountId
     * @return array
     */
    public function findAllMoviesToAccount(int $accountId): array
    {
        $sql = "SELECT m.title, m.description, m.publish_at, m.cover
                FROM movies m
                INNER JOIN account_movie am ON m.id = am.movie_id
                WHERE am.account_id = :account_id
                ORDER BY m.title ASC";

        $stmt = $this->connect->prepare($sql);
        // bindParam as requested (binds by reference)
        $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Remove a movie from an account.
     * Returns true if a row was deleted, false otherwise.
     */
    public function removeMovieFromAccount(int $accountId, int $movieId): bool
    {
        $sql = 'DELETE FROM account_movie WHERE account_id = :account_id AND movie_id = :movie_id';
        $stmt = $this->connect->prepare($sql);
        $stmt->bindValue(':account_id', $accountId, PDO::PARAM_INT);
        $stmt->bindValue(':movie_id', $movieId, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return (bool)$stmt->rowCount();
        } catch (\PDOException $e) {
            // could log error
            return false;
        }
    }
}
