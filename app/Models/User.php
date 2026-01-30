<?php
require_once __DIR__ . '/../Repositories/AccountRepository.php';

class User
{
    private int $id_user;
    private string $email;
    private string $prenom;
    private string $nom;
    private string $role;
    private array $accounts = [];

    /**
     * @var Account[]
     */

    /**
     * User constructor
     * A user is automatically created with exactly two accounts:
     * - One OFFSHORE account
     * - One OFFSHORE_PLUS account
     */
    public function __construct(
        int $id_user,
        string $email,
        string $prenom,
        string $nom,
        string $role
    ) {
        $this->id_user = $id_user;
        $this->email   = $email;
        $this->prenom  = $prenom;
        $this->nom     = $nom;
        $this->role    = $role;

        // Automatically create the two mandatory accounts
        $this->accounts[] = new Account(
            1,
            '00012345001',
            'OFFSHORE'
        );

        $this->accounts[] = new Account(
            2,
            '00012345002',
            'OFFSHORE_PLUS'
        );
    }

    /**
     * Return all user accounts
     */
    public function getAccounts(): array
    {
        $repository = new AccountRepository();

        return $repository->findByUserId($this->id_user);
    }


    /**
     * Return the role of the user (USER or ADMIN)
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Add a new account to the user (should never exceed 2 accounts)
     */
    public function addAccount(Account $account): void
    {
        if (count($this->accounts) >= 2) {
            throw new LogicException('A user cannot have more than two accounts');
        }

        $this->accounts[] = $account;
    }
}
