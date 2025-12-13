<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/Models/Account.php';

class AccountTest extends TestCase
{
    public function testNumCompteMustBeStringWith11Digits()
    {
        $account = new Account(
            1,
            '00012345678', // ✅ 11 chiffres, string, zéros autorisés
            'OFFSHORE'
        );

        $this->assertSame('00012345678', $account->getNumCompte());
        $this->assertMatchesRegularExpression('/^\d{11}$/', $account->getNumCompte());
    }

    public function testNumCompteWithLessThan11DigitsIsRejected()
    {
        $this->expectException(InvalidArgumentException::class);

        new Account(
            1,
            '123456', // ❌ trop court
            'OFFSHORE'
        );
    }

    public function testNumCompteWithMoreThan11DigitsIsRejected()
    {
        $this->expectException(InvalidArgumentException::class);

        new Account(
            1,
            '123456789012', // ❌ trop long
            'OFFSHORE'
        );
    }

    public function testNumCompteWithLettersIsRejected()
    {
        $this->expectException(InvalidArgumentException::class);

        new Account(
            1,
            'ABC12345678', // ❌ contient des lettres
            'OFFSHORE'
        );
    }

    public function testIbanIsAutomaticallyGeneratedForOffshore()
    {
        $account = new Account(
            1,
            '00012345678',
            'OFFSHORE'
        );

        $this->assertSame(
            'LU89 0061 1014 0372 1090',
            $account->getIban()
        );
    }

    public function testIbanIsAutomaticallyGeneratedForOffshorePlus()
    {
        $account = new Account(
            2,
            '00012345679',
            'OFFSHORE_PLUS'
        );

        $this->assertSame(
            'LU89 0061 1014 0372 1092',
            $account->getIban()
        );
    }

    public function testInvalidAccountTypeIsRejected()
    {
        $this->expectException(InvalidArgumentException::class);

        new Account(
            3,
            '00012345680',
            'PREMIUM' // Invalid type
        );
    }
    public function testAdminCanChangeAccountStatus()
    {
        $account = new Account(
            1,
            '00012345678',
            'OFFSHORE'
        );

        $account->setStatus('BLOCKED', 'ADMIN');

        $this->assertSame('BLOCKED', $account->getStatus());
    }

    public function testUserCannotChangeAccountStatus()
    {
        $this->expectException(InvalidArgumentException::class);

        $account = new Account(
            2,
            '00012345679',
            'OFFSHORE_PLUS'
        );

        // USER is not allowed to change account status
        $account->setStatus('BLOCKED', 'USER');
    }

}
