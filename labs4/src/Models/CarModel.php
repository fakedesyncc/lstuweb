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

    public function getAll(int $page = 1, int $perPage = 10): array
    {
        return $this->repository->findAll($perPage, ($page - 1) * $perPage);
    }

    public function getById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function search(array $criteria, int $page = 1, int $perPage = 10): array
    {
        return $this->repository->search($criteria, $perPage, ($page - 1) * $perPage);
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
