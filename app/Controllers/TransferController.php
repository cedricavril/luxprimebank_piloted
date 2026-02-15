<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransferService;
use InvalidArgumentException;

class TransferController
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function handle(): void
    {
        try {
            $this->assertUserIsAuthenticated();
            $data = $this->validateRequest();

            $this->transferService->execute(
                $_SESSION['user'],
                $data['source_account_id'],
                $data['target_account_id'],
                $data['amount']
            );

            $_SESSION['flash_success'] = 'Transfer completed successfully';

        } catch (InvalidArgumentException $e) {

            $_SESSION['flash_error'] = $e->getMessage();

        } catch (\Throwable $e) {

            $_SESSION['flash_error'] = 'Unexpected error during transfer';
        }

        header('Location: /');
        exit;
    }

    private function validateRequest(): array
    {
        if (
            !isset($_POST['source_account_id'], $_POST['target_account_id'], $_POST['amount'])
        ) {
            throw new InvalidArgumentException('Missing transfer data');
        }

        $sourceAccountId = (int) $_POST['source_account_id'];
        $targetAccountId = (int) $_POST['target_account_id'];
        $amount = (float) $_POST['amount'];

        if ($sourceAccountId <= 0 || $targetAccountId <= 0) {
            throw new InvalidArgumentException('Invalid account selection');
        }

        if ($amount <= 0) {
            throw new InvalidArgumentException('Transfer amount must be greater than zero');
        }

        return [
            'source_account_id' => $sourceAccountId,
            'target_account_id' => $targetAccountId,
            'amount' => $amount,
        ];
    }

    private function assertUserIsAuthenticated(): void
    {
        if (!isset($_SESSION['user'])) {
            throw new InvalidArgumentException('User not authenticated');
        }
    }
}
