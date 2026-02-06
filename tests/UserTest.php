<?php

use PHPUnit\Framework\TestCase;

/*require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/User.php';
*/
class UserTest extends TestCase
{
    protected function tearDown(): void
    {
        Database::reset();
    }

    public function testUserReturnsAccountsFromDatabase(): void
    {
        $user = new User(
            1,
            'john.doe@test.com',
            'John',
            'Doe',
            'USER'
        );

        $accounts = $user->getAccounts();

        $this->assertIsArray($accounts);
        $this->assertCount(2, $accounts);
        $this->assertInstanceOf(Account::class, $accounts[0]);
    }
}
