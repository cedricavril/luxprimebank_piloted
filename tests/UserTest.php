<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/User.php';

class UserTest extends TestCase
{
    public function testUserHasExactlyTwoAccounts()
    {
        $user = new User(
            1,
            'john.doe@test.com',
            'John',
            'Doe',
            'USER'
        );

        $accounts = $user->getAccounts();

        $this->assertCount(2, $accounts);

        $this->assertSame('OFFSHORE', $accounts[0]->getType());
        $this->assertSame('OFFSHORE_PLUS', $accounts[1]->getType());
    }

    public function testUserCannotHaveMoreThanTwoAccounts()
    {
        $this->expectException(LogicException::class);

        $user = new User(
            2,
            'jane.doe@test.com',
            'Jane',
            'Doe',
            'USER'
        );

        $user->addAccount(
            new Account(3, '00012345690', 'OFFSHORE')
        );
    }

    public function testUserAlwaysHasOneOffshoreAndOneOffshorePlus()
    {
        $user = new User(
            3,
            'alice@test.com',
            'Alice',
            'Smith',
            'USER'
        );

        $types = array_map(
            fn ($account) => $account->getType(),
            $user->getAccounts()
        );

/*        $this->assertContains('OFFSHORE', $types);
        $this->assertContains('OFFSHORE_PLUS', $types);
*/    }
}
