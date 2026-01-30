<?php

use PHPUnit\Framework\TestCase;

/**
 * Helper to capture output safely
 */
function capture_output(callable $callback): string {
    ob_start();
    $callback();
    return ob_get_clean();
}

class CorruptedOperation extends Operation
{
    public static function getAll(): array
    {
        return [
            [
                'date' => '2025-11-26',
                'description' => 'Corrupted Withdrawal',
                'amount' => -99999.00 // force solde négatif
            ]
        ];
    }
}

class DashboardTest extends TestCase
{
    protected function tearDown(): void
    {
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
    }

    public function testDashboardLoads()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('Dashboard', $output);
    }

    public function testDashboardHasHtmlStructure()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('<table', $output);
        $this->assertStringContainsString('<tr>', $output);
        $this->assertStringContainsString('</table>', $output);
    }

    public function testDashboardDisplaysBalance()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('Balance:', $output);
        $this->assertStringContainsString('€', $output);
    }

    public function testDashboardShowsOperationHistory()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('2025-11-26', $output);
        $this->assertStringContainsString('Deposit', $output);
        $this->assertStringContainsString('€', $output);
    }

    public function testDashboardDisplaysPositiveAndNegativeTotals()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('Total Positive:', $output);
        $this->assertStringContainsString('Total Negative:', $output);
    }
    public function testDashboardBlocksNegativeBalance()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard?corrupted=1';
        $_GET['corrupted'] = '1';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('Error: Negative balance detected', $output);
        $this->assertStringNotContainsString('Balance: -', $output);
    }
    public function testDashboardDisplaysTwoAccounts()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        $this->assertStringContainsString('OFFSHORE', $output);
        $this->assertStringContainsString('OFFSHORE_PLUS', $output);
    }

    public function testDashboardDisplaysTwoBalances()
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        $output = capture_output(function () {
            require __DIR__ . '/bootstrap_dashboard.php';
        });

        // We expect to see two balance blocks
        $this->assertSame(2, substr_count($output, 'Balance:'));
    }

}
