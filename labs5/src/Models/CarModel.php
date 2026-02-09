<?php

namespace App\Models;

use App\Repository\CarRepository;

/**
 * @author fakedesyncc
 */
class CarModel
{
    private CarRepository $repository;

    public function __construct()
    {
        $this->repository = new CarRepository();
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function getByUserId(int $userId): array
    {
        return $this->repository->findByUserId($userId);
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
}
