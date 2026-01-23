<?php
use PHPUnit\Framework\TestCase;

// ===============================
// ✅ Includes PHP natif
// ===============================
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Repositories/AccountRepository.php';

class AccountRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        // On force l'environnement test si besoin
        putenv('APP_ENV=test');

        $pdo = Database::getConnection();

        // ⚡ Nettoyer la table avant chaque test
        $pdo->exec('DELETE FROM accounts');

        // ⚡ Charger les fixtures SQL
        $sqlFile = __DIR__ . '/Fixtures/accounts.sql';
        if (file_exists($sqlFile)) {
            $sql = file_get_contents($sqlFile);
            $pdo->exec($sql);
        } else {
            throw new RuntimeException("Fixtures file not found: $sqlFile");
        }
    }

    public function testFindByUserIdReturnsAccounts(): void
    {
        $repo = new AccountRepository();

        $accounts = $repo->findByUserId(1);

        // ✅ On doit récupérer exactement 2 comptes selon nos fixtures
        $this->assertCount(2, $accounts);

        // ✅ Chaque objet doit être une instance de Account
        $this->assertInstanceOf(Account::class, $accounts[0]);
        $this->assertInstanceOf(Account::class, $accounts[1]);

        // ✅ Vérifier quelques valeurs métiers
}
}