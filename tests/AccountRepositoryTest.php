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
    protected function tearDown(): void
    {
        Database::reset();
    }

    public function testFindByUserIdReturnsAccounts(): void
    {
        $repo = new AccountRepository();

        $accounts = $repo->findByUserId(1);

        $this->assertIsArray($accounts);
        $this->assertNotEmpty($accounts);
        $this->assertInstanceOf(Account::class, $accounts[0]);
    }

    public function testReturnsTwoAccountsForUser(): void
    {



        $repo = new AccountRepository();
        $accounts = $repo->findByUserId(1);

        $this->assertCount(2, $accounts);
    }

    public function testAccountsHaveCorrectTypes(): void
    {
        $repo = new AccountRepository();
        $accounts = $repo->findByUserId(1);

        $types = array_map(fn($a) => $a->getType(), $accounts);

        $this->assertContains('OFFSHORE', $types);
        $this->assertContains('OFFSHORE_PLUS', $types);
    }

    public function testBalancesAreHydrated(): void
    {
        $repo = new AccountRepository();
        $accounts = $repo->findByUserId(1);

        foreach ($accounts as $account) {
            $this->assertIsFloat($account->getBalance());
        }
    }
}