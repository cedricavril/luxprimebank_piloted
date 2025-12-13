<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Account.php';

class AdminAccountController
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Block an account only if the user is ADMIN
     */
    public function blockAccount(Account $account): bool
    {
        if ($this->user->getRole() !== 'ADMIN') {
            return false;
        }

        $account->setStatus('BLOCKED');
        return true;
    }
}
