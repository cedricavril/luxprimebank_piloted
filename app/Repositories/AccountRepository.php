<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Account.php';

class AccountRepository
{
    public function findByUserId(int $userId): array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare(
            'SELECT id, num_compte, type, iban, solde, status
             FROM accounts
             WHERE user_id = :user_id'
        );

        $stmt->execute(['user_id' => $userId]);

        $accounts = [];

        foreach ($stmt->fetchAll() as $row) {
            $accounts[] = new Account(
                id_compte: (int) $row['id'],
                num_compte: $row['num_compte'],
                type: $row['type'],
                iban: $row['iban'],
                solde: (float) $row['solde'],
                status: $row['status']
            );
        }

        return $accounts;
    }
}
