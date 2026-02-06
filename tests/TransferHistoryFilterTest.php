<?php

use PHPUnit\Framework\TestCase;

/*require_once __DIR__ . '/../app/Models/Account.php';
require_once __DIR__ . '/../app/Models/Transfer.php';
require_once __DIR__ . '/../app/Models/TransferHistory.php';
*/
class TransferHistoryFilterTest extends TestCase
{
    protected function setUp(): void
    {
        TransferHistory::clear();
    }

    public function testFilterTransfersBySourceAccount()
    {
        $a1 = new Account(1, '00000000001', 'OFFSHORE');
        $a2 = new Account(2, '00000000002', 'OFFSHORE_PLUS');
        $a3 = new Account(3, '00000000003', 'OFFSHORE');

        (new Transfer($a1, $a2, 100))->execute(); // from a1
        (new Transfer($a3, $a2, 50))->execute();  // from a3
        (new Transfer($a1, $a3, 25))->execute();  // from a1

        $filtered = TransferHistory::getBySourceAccount($a1->getId());

        $this->assertCount(2, $filtered);

        foreach ($filtered as $row) {
            $this->assertSame($a1->getId(), $row['source_account_id']);
        }
    }

    public function testFilterTransfersByTargetAccount()
    {
        $a1 = new Account(4, '00000000004', 'OFFSHORE');
        $a2 = new Account(5, '00000000005', 'OFFSHORE_PLUS');

        (new Transfer($a1, $a2, 70))->execute();
        (new Transfer($a2, $a1, 30))->execute();

        $filtered = TransferHistory::getByTargetAccount($a1->getId());

        $this->assertCount(1, $filtered);
        $this->assertSame($a1->getId(), $filtered[0]['target_account_id']);
    }
}
