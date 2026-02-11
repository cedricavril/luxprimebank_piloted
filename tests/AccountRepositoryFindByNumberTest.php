<?php

use PHPUnit\Framework\TestCase;
/*use App\Repositories\AccountRepository;
use App\Models\Account;
*/
class AccountRepositoryFindByNumberTest extends TestCase
{
    public function testFindByAccountNumberReturnsAccountWhenExists(): void
    {
        $repository = new AccountRepository();

        $account = $repository->findByAccountNumber('00000000001');

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals('00000000001', $account->getNumCompte());
    }

    public function testFindByAccountNumberReturnsNullWhenNotExists(): void
    {
        $repository = new AccountRepository();

        $account = $repository->findByAccountNumber('99999999999');

        $this->assertNull($account);
    }

    public function testAccountIsFullyHydratedWhenFound(): void
    {
        $repository = new AccountRepository();

        $account = $repository->findByAccountNumber('00000000001');

        $this->assertInstanceOf(Account::class, $account);
        $this->assertIsString($account->getType());
        $this->assertIsString($account->getIban());
        $this->assertIsString($account->getStatus());
        $this->assertIsFloat($account->getBalance());
    }
}
