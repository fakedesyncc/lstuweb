<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Validation\UserValidator;

/**
 * @author fakedesyncc
 */
class UserService
{
    private UserRepository $repository;

    public function __construct(?UserRepository $repository = null)
    {
        $this->repository = $repository ?? new UserRepository();
    }

    public function register(array $data): array
    {
        $errors = UserValidator::validateRegistration($data);
        
        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . json_encode($errors));
        }

        $sanitized = UserValidator::sanitize($data);

        if ($this->repository->findByUsername($sanitized['username'])) {
            throw new \RuntimeException('Username already exists');
        }

        if ($this->repository->findByEmail($sanitized['email'])) {
            throw new \RuntimeException('Email already exists');
        }

        $id = $this->repository->create($sanitized);
        $user = $this->repository->findById($id);
        if ($user === null) {
            throw new \RuntimeException('Failed to retrieve created user');
        }
        return $user;
    }

    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->repository->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            return null;
        }

        unset($user['password']);
        return $user;
    }

    public function getById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function update(int $id, array $data): array
    {
        if (!$this->repository->update($id, $data)) {
            throw new \RuntimeException('Failed to update user');
        }

        $user = $this->repository->findById($id);
        if ($user === null) {
            throw new \RuntimeException('Failed to retrieve updated user');
        }

        return $user;
    }
}
