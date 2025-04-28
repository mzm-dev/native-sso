<?php

namespace Mzm\PhpSso\Database;

class DefaultUserFinder implements UserFinderInterface
{
    public function findLocalUser(array $userData): ?array
    {
        // Contoh SQL asas
        $email = $userData['email'] ?? null;
        $username = $userData['username'] ?? null;

        if (!$email && !$username) {
            return null;
        }

        $dsn = "mysql:host=localhost;dbname=gerakdb;charset=utf8mb4";
        $pdo = new \PDO($dsn, 'root', 'password');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username LIMIT 1");
        $stmt->execute([
            'email' => $email,
            'username' => $username
        ]);

        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
