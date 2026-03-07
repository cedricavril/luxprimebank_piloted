<?php
/**
 * Authentication service (foundation).
 * Email + password authentication.
 */
class AuthService
{
    private $userRepository;
    private $session;

    public function __construct($userRepository, $session)
    {
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    public function login(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
 
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->getPasswordHash())) {
            return false;
        }

        $this->session->set('user', $user);

        return true;
    }
}