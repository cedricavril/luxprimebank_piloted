<?php

use PHPUnit\Framework\TestCase;

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
            password_hash('secret', PASSWORD_DEFAULT),
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
