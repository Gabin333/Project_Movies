<?php
require __DIR__ . '/../config/db.php';

try {
    /** @var PDO $pdo */
    $stmt = $pdo->query("SHOW CREATE TABLE account_movie");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        echo "Table 'account_movie' does not exist.\n";
        exit(0);
    }

    // MySQL returns array with keys: 'Table' and 'Create Table' (exact key may vary)
    $createKey = null;
    foreach ($row as $k => $v) {
        if (stripos($k, 'create') !== false) { $createKey = $k; break; }
    }

    echo "SHOW CREATE TABLE account_movie;\n\n";
    if ($createKey !== null) {
        echo $row[$createKey] . "\n";
    } else {
        // fallback: print all
        print_r($row);
    }
} catch (Throwable $e) {
    echo "Error executing SHOW CREATE TABLE account_movie: " . $e->getMessage() . "\n";
    exit(1);
}
