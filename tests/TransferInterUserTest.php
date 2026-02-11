<?php

use PHPUnit\Framework\TestCase;

/*use App\Models\Account;
use App\Models\Transfer;
use App\Models\TransferHistory;
use App\Repositories\AccountRepository;
*/
class TransferInterUserTest extends TestCase
{
    protected function setUp(): void
    {
        TransferHistory::clear();
    }

    public function testTransferToAnotherUserAccountSucceeds(): void
    {
        $source = new Account(
            id_compte: 1,
            num_compte: '00000000001',
            type: 'OFFSHORE',
            solde: 500.0
        );

        $target = new Account(
            id_compte: 2,
            num_compte: '00000000002',
            type: 'OFFSHORE',
            solde: 100.0
        );

        $transfer = new Transfer($source, $target, 200.0);
        $result = $transfer->execute();

        $this->assertTrue($result);
        $this->assertEquals(300.0, $source->getBalance());
        $this->assertEquals(300.0, $target->getBalance());
    }

    public function testTransferBetweenOwnAccountsSucceeds(): void
    {
        $offshore = new Account(
            id_compte: 1,
            num_compte: '00000000001',
            type: 'OFFSHORE',
            solde: 1000.0
        );

        $offshorePlus = new Account(
            id_compte: 2,
            num_compte: '00000000002',
            type: 'OFFSHORE_PLUS',
            solde: 0.0
        );

        $transfer = new Transfer($offshore, $offshorePlus, 250.0);
        $result = $transfer->execute();

        $this->assertTrue($result);
        $this->assertEquals(750.0, $offshore->getBalance());
        $this->assertEquals(250.0, $offshorePlus->getBalance());
    }

    public function testTransferToSameAccountIsRejected(): void
    {
        $account = new Account(
            id_compte: 1,
            num_compte: '00000000001',
            type: 'OFFSHORE',
            solde: 500.0
        );

        $transfer = new Transfer($account, $account, 100.0);
        $result = $transfer->execute();

        $this->assertFalse($result);
        $this->assertEquals(500.0, $account->getBalance());
    }

    public function testInterUserTransferIsLogged(): void
    {
        $source = new Account(
            id_compte: 1,
            num_compte: '00000000001',
            type: 'OFFSHORE',
            solde: 500.0
        );

        $target = new Account(
            id_compte: 2,
            num_compte: '00000000002',
            type: 'OFFSHORE',
            solde: 100.0
        );

        $transfer = new Transfer($source, $target, 100.0);
        $transfer->execute();

        $history = TransferHistory::getAll();

        $this->assertCount(1, $history);
        $this->assertEquals(1, $history[0]['source_account_id']);
        $this->assertEquals(2, $history[0]['target_account_id']);
        $this->assertEquals(100.0, $history[0]['amount']);
        $this->assertEquals('SUCCESS', $history[0]['status']);
    }
}
