<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Account.php';

class AccountRepository
{
    public function findByUserId(int $userId): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT id, num_compte, type, iban, solde, status
            FROM accounts
            WHERE user_id = :user_id
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $accounts = [];

        foreach ($rows as $row) {
            $accounts[] = new Account(
                (int) $row['id'],
                $row['num_compte'],
                $row['type'],
                $row['iban'],
                (float) $row['solde'],
                $row['status']
            );
        }

        return $accounts;
    }
}
