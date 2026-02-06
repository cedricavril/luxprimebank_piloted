<?php

use PHPUnit\Framework\TestCase;

/*require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/Transfer.php';
*/
class TransferTest extends TestCase
{
    public function testSuccessfulTransfer()
    {
        $source = new Account(1, '00000000001', 'OFFSHORE');
        $target = new Account(2, '00000000002', 'OFFSHORE_PLUS');

        $initialSourceBalance = $source->getBalance();
        $initialTargetBalance = $target->getBalance();

        $transfer = new Transfer($source, $target, 200);

        $this->assertTrue($transfer->execute());

        $this->assertSame(
            $initialSourceBalance - 200,
            $source->getBalance()
        );

        $this->assertSame(
            $initialTargetBalance + 200,
            $target->getBalance()
        );
    }

    public function testTransferIsBlockedIfAmountExceedsSourceBalance()
    {
        $source = new Account(3, '00000000003', 'OFFSHORE');
        $target = new Account(4, '00000000004', 'OFFSHORE_PLUS');

        $initialSourceBalance = $source->getBalance();
        $initialTargetBalance = $target->getBalance();

        // Transfer more than available balance
        $transfer = new Transfer($source, $target, $initialSourceBalance + 100);

        $this->assertFalse($transfer->execute());

        // Balances must remain unchanged
        $this->assertSame($initialSourceBalance, $source->getBalance());
        $this->assertSame($initialTargetBalance, $target->getBalance());
    }
    public function testTransferIsBlockedIfSourceAccountIsBlocked()
    {
        $source = new Account(5, '00000000005', 'OFFSHORE');
        $target = new Account(6, '00000000006', 'OFFSHORE_PLUS');

        $source->setStatus('BLOCKED', 'ADMIN');

        $transfer = new Transfer($source, $target, 100);

        $this->assertFalse($transfer->execute());
    }
    public function testTransferIsBlockedIfTargetAccountIsBlocked()
    {
        $source = new Account(7, '00000000007', 'OFFSHORE');
        $target = new Account(8, '00000000008', 'OFFSHORE_PLUS');

        $target->setStatus('BLOCKED', 'ADMIN');

        $transfer = new Transfer($source, $target, 100);

        $this->assertFalse($transfer->execute());
    }
}
