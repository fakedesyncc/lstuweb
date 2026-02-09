<?php

namespace App\Models;

use App\Repository\UserRepository;

/**
 * @author fakedesyncc
 */
class UserModel
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }

    public function findByUsername(string $username): ?array
    {
        return $this->repository->findByUsername($username);
    }

    public function findByEmail(string $email): ?array
    {
        return $this->repository->findByEmail($email);
    }

    public function create(array $data): bool
    {
        try {
            $this->repository->create($data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getById(int $id): ?array
    {
        return $this->repository->findById($id);
    }
}
