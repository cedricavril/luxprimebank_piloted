<?php

use PHPUnit\Framework\TestCase;

/*require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/Transfer.php';
require_once __DIR__ . '/../app/Models/TransferHistory.php';
*/
class TransferHistoryTest extends TestCase
{
    protected function setUp(): void
    {
        TransferHistory::clear();
    }

    public function testSuccessfulTransferIsLogged()
    {
        $source = new Account(1, '00000000001', 'OFFSHORE');
        $target = new Account(2, '00000000002', 'OFFSHORE_PLUS');

        $transfer = new Transfer($source, $target, 100);
        $this->assertTrue($transfer->execute());

        $history = TransferHistory::getAll();

        $this->assertCount(1, $history);
        $this->assertSame('SUCCESS', $history[0]['status']);
        $this->assertSame(100.0, $history[0]['amount']);
    }

    public function testFailedTransferIsLogged()
    {
        $source = new Account(3, '00000000003', 'OFFSHORE');
        $target = new Account(4, '00000000004', 'OFFSHORE_PLUS');

        // Create an impossible transfer
        $transfer = new Transfer($source, $target, 999999);

        $this->assertFalse($transfer->execute());

        $history = TransferHistory::getAll();

        $this->assertCount(1, $history);
        $this->assertSame('FAILED', $history[0]['status']);
    }
}
