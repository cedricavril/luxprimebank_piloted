<?php

/*require_once __DIR__ . '/../Repositories/AccountRepository.php';*/

class User
{
    private int $id_user;
    private string $email;
    private string $passwordHash;
    private string $firstname;
    private string $lastname;
    private string $role;

    public function __construct(
        int $id_user,
        string $email,
        string $passwordHash,
        string $firstname,
        string $lastname,
        string $role
    ) {
        $this->id_user = $id_user;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->role = $role;
    }

    public function getAccounts(): array
    {
        $repo = new AccountRepository();
        return $repo->findByUserId($this->id_user);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

}
