<?php

// LOAD all required classes manually
/*require_once __DIR__ . '/bootstrap_dashboard.php';*/
require_once __DIR__ . '/bootstrap_auth_test.php';

$_SERVER['REQUEST_URI'] = '/dashboard';

use PHPUnit\Framework\TestCase;
/*use App\Services\AuthService;
use App\Models\User;*/

/**
 * Authentication service tests.
 * Email + password authentication (foundation).
 */
class AuthServiceTest extends TestCase
{
    public function testLoginSucceedsWithValidCredentials(): void
    {
        $session = new FakeSessionManager();
        $repository = new FakeUserRepository();
        $authService = new AuthService($repository, $session);

        $result = $authService->login('user@test.com', 'secret');

        $this->assertTrue($result);
        $this->assertInstanceOf(User::class, $session->get('user'));
        $this->assertEquals('user@test.com', $session->get('user')->getEmail());
    }

    public function testLoginFailsWithInvalidPassword(): void
    {
        $session = new FakeSessionManager();
        $repository = new FakeUserRepository();
        $authService = new AuthService($repository, $session);

        $result = $authService->login('user@test.com', 'wrong-password');

        $this->assertFalse($result);
        $this->assertNull($session->get('user'));
    }

    public function testLoginFailsWithUnknownEmail(): void
    {
        $session = new FakeSessionManager();
        $repository = new FakeUserRepository();
        $authService = new AuthService($repository, $session);

        $result = $authService->login('unknown@test.com', 'secret');

        $this->assertFalse($result);
        $this->assertNull($session->get('user'));
    }

}

/**
 * Fake in-memory session manager for tests.
 */
class FakeSessionManager
{
    private array $data = [];

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function clear(): void
    {
        $this->data = [];
    }
}

/**
 * Fake user repository for authentication tests.
 */
class FakeUserRepository
{
    public function findByEmail(string $email): ?User
    {
        if ($email !== 'user@test.com') {
            return null;
        }



$userTest = new User(
            1,
            'user@test.com',
            password_hash('secret', PASSWORD_DEFAULT),
            'John',
            'Doe',
            'USER'
            ); 

        return new User(
            1,
            'user@test.com',
            password_hash('secret', PASSWORD_DEFAULT),
            'John',
            'Doe',
            'USER'
            );   
    }
}