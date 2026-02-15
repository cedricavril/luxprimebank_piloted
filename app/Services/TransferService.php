<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use App\Models\Transfer;
use App\Repositories\AccountRepository;
use App\Models\User;
use DomainException;

class TransferService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function execute(
        User $user,
        int $sourceAccountId,
        int $targetAccountId,
        float $amount
    ): bool {
        $sourceAccount = $this->findAccountOrFail($sourceAccountId);
        $targetAccount = $this->findAccountOrFail($targetAccountId);

        $this->assertSourceAccountBelongsToUser($user, $sourceAccount);

        $transfer = new Transfer(
            $sourceAccount,
            $targetAccount,
            $amount
        );

        if (!$transfer->execute()) {
            throw new DomainException('Transfer failed');
        }

        return true;
    }

    private function findAccountOrFail(int $accountId): Account
    {
        $account = $this->accountRepository->findById($accountId);

        if ($account === null) {
            throw new DomainException('Account not found');
        }

        return $account;
    }

    private function assertSourceAccountBelongsToUser(
        User $user,
        Account $account
    ): void {
        foreach ($user->getAccounts() as $userAccount) {
            if ($userAccount->getId() === $account->getId()) {
                return;
            }
        }

        throw new DomainException('Source account does not belong to user');
    }
}
