<?php
require __DIR__ . '/../config/db.php';

/**
 * Script to convert id columns to INT UNSIGNED AUTO_INCREMENT.
 * It temporarily drops foreign key constraints referencing movies.id or accounts.id,
 * alters the columns, then re-adds the constraints with the same rules.
 * Run from project-root with: php tools/alter_ids.php
 */
try {
    /** @var PDO $pdo */
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

    // Find foreign keys that reference movies.id or accounts.id
    $sql = "SELECT k.TABLE_NAME, k.CONSTRAINT_NAME, k.COLUMN_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME
            FROM information_schema.KEY_COLUMN_USAGE k
            WHERE k.REFERENCED_TABLE_SCHEMA = DATABASE()
              AND (k.REFERENCED_TABLE_NAME = 'movies' OR k.REFERENCED_TABLE_NAME = 'accounts')";

    $stmt = $pdo->query($sql);
    $fks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Store FK definitions to recreate later
    $fkDefinitions = [];
    foreach ($fks as $fk) {
        $childTable = $fk['TABLE_NAME'];
        $constraint = $fk['CONSTRAINT_NAME'];
        $childCol = $fk['COLUMN_NAME'];
        $parentTable = $fk['REFERENCED_TABLE_NAME'];
        $parentCol = $fk['REFERENCED_COLUMN_NAME'];

        // get delete/update rules
        $ruleStmt = $pdo->prepare("SELECT UPDATE_RULE, DELETE_RULE FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE() AND CONSTRAINT_NAME = :cname AND UNIQUE_CONSTRAINT_NAME = :cname");
        $ruleStmt->execute([':cname' => $constraint]);
        $rule = $ruleStmt->fetch(PDO::FETCH_ASSOC);
        $updateRule = $rule['UPDATE_RULE'] ?? 'NO ACTION';
        $deleteRule = $rule['DELETE_RULE'] ?? 'NO ACTION';

        $fkDefinitions[] = [
            'table' => $childTable,
            'constraint' => $constraint,
            'column' => $childCol,
            'parent_table' => $parentTable,
            'parent_column' => $parentCol,
            'update_rule' => $updateRule,
            'delete_rule' => $deleteRule,
        ];

        // Drop the FK
        $pdo->exec(sprintf('ALTER TABLE `%s` DROP FOREIGN KEY `%s`', $childTable, $constraint));
        echo "Dropped foreign key {$constraint} on {$childTable}\n";
    }

    // Ensure engines
    $pdo->exec("ALTER TABLE movies ENGINE = InnoDB");
    $pdo->exec("ALTER TABLE accounts ENGINE = InnoDB");

    // Alter id columns
    $pdo->exec("ALTER TABLE movies MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT");
    echo "Altered movies.id to INT UNSIGNED AUTO_INCREMENT\n";
    $pdo->exec("ALTER TABLE accounts MODIFY id INT UNSIGNED NOT NULL AUTO_INCREMENT");
    echo "Altered accounts.id to INT UNSIGNED AUTO_INCREMENT\n";

    // Recreate previously dropped foreign keys
    foreach ($fkDefinitions as $def) {
        $childTable = $def['table'];
        $constraint = $def['constraint'];
        $childCol = $def['column'];
        $parentTable = $def['parent_table'];
        $parentCol = $def['parent_column'];
        $updateRule = $def['update_rule'];
        $deleteRule = $def['delete_rule'];

        $sqlAdd = sprintf(
            'ALTER TABLE `%s` ADD CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s`(`%s`) ON UPDATE %s ON DELETE %s',
            $childTable,
            $constraint,
            $childCol,
            $parentTable,
            $parentCol,
            $updateRule,
            $deleteRule
        );

        $pdo->exec($sqlAdd);
        echo "Recreated foreign key {$constraint} on {$childTable}\n";
    }

    // Ensure account_movie exists (if not already)
    $pdo->exec('CREATE TABLE IF NOT EXISTS account_movie (
        account_id INT UNSIGNED NOT NULL,
        movie_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (account_id, movie_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    echo "Done: conversion completed.\n";
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "You can inspect tables with SHOW CREATE TABLE movies; and SHOW CREATE TABLE accounts;\n";
    exit(1);
}
