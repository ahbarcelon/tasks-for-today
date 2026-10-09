<?php

declare(strict_types=1);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$database = new mysqli(
    (string) getenv('MYSQLHOST'),
    (string) getenv('MYSQLUSER'),
    (string) getenv('MYSQLPASSWORD'),
    (string) getenv('MYSQLDATABASE'),
    (int) (getenv('MYSQLPORT') ?: 3306),
);
$database->set_charset('utf8mb4');

$database->begin_transaction();

try {
    $database->query(<<<'SQL'
        CREATE TABLE IF NOT EXISTS tasks (
            id INT NOT NULL AUTO_INCREMENT,
            title VARCHAR(150) NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            task_date DATE NOT NULL,
            created_at DATETIME NOT NULL,
            is_archived TINYINT(1) NOT NULL DEFAULT 0,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        SQL);

    $database->query(<<<'SQL'
        CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(50) NOT NULL,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL DEFAULT '',
            created_at DATETIME NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY users_username_unique (username)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        SQL);

    $database->query(<<<'SQL'
        CREATE TABLE IF NOT EXISTS migrations (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            version VARCHAR(255) NOT NULL,
            class VARCHAR(255) NOT NULL,
            `group` VARCHAR(255) NOT NULL,
            namespace VARCHAR(255) NOT NULL,
            time INT NOT NULL,
            batch INT UNSIGNED NOT NULL,
            PRIMARY KEY (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        SQL);

    $passwordHash = password_hash('DemoPassword123!', PASSWORD_DEFAULT);
    $user = $database->prepare(<<<'SQL'
        INSERT INTO users (username, full_name, email, password, created_at)
        VALUES ('demo.student', 'Demo Student', 'demo.student@example.com', ?, NOW())
        ON DUPLICATE KEY UPDATE
            full_name = VALUES(full_name),
            email = VALUES(email),
            password = VALUES(password)
        SQL);
    $user->bind_param('s', $passwordHash);
    $user->execute();

    $migrations = [
        ['2026-10-02-000001', 'App\\Database\\Migrations\\CreateTasksAndUsers'],
        ['2026-10-09-000002', 'App\\Database\\Migrations\\AddAuthenticationAndArchiving'],
    ];

    $exists = $database->prepare('SELECT COUNT(*) FROM migrations WHERE version = ? AND class = ? AND namespace = ?');
    $insert = $database->prepare('INSERT INTO migrations (version, class, `group`, namespace, time, batch) VALUES (?, ?, \'default\', ?, ?, 1)');
    $namespace = 'App';
    $timestamp = time();

    foreach ($migrations as [$version, $class]) {
        $exists->bind_param('sss', $version, $class, $namespace);
        $exists->execute();
        $count = (int) $exists->get_result()->fetch_row()[0];

        if ($count === 0) {
            $insert->bind_param('sssi', $version, $class, $namespace, $timestamp);
            $insert->execute();
        }
    }

    $database->commit();
    fwrite(STDOUT, "Database schema and demo user are ready.\n");
} catch (Throwable $exception) {
    $database->rollback();
    fwrite(STDERR, "Database bootstrap failed: {$exception->getMessage()}\n");
    exit(1);
}

