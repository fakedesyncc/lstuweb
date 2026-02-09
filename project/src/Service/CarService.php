<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Validation\CarValidator;

/**
 * @author fakedesyncc
 */
class CarService
{
    private CarRepository $repository;

    public function __construct(?CarRepository $repository = null)
    {
        $this->repository = $repository ?? new CarRepository();
    }

    public function getAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->repository->findAll($perPage, $offset);
    }

    public function getById(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function getByUserId(int $userId): array
    {
        return $this->repository->findByUserId($userId);
    }

    public function search(array $criteria, int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        return $this->repository->search($criteria, $perPage, $offset);
    }

    public function getTotalCount(array $criteria = []): int
    {
        return $this->repository->count($criteria);
    }

    public function create(array $data): array
    {
        $errors = CarValidator::validate($data);
        
        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . json_encode($errors));
        }

        $sanitized = CarValidator::sanitize($data);
        $id = $this->repository->create($sanitized);
        
        $car = $this->repository->findById($id);
        if ($car === null) {
            throw new \RuntimeException('Failed to retrieve created car');
        }
        
        return $car;
    }

    public function update(int $id, array $data): array
    {
        $errors = CarValidator::validate($data);
        
        if (!empty($errors)) {
            throw new \InvalidArgumentException('Validation failed: ' . json_encode($errors));
        }

        $sanitized = CarValidator::sanitize($data);
        
        if (!$this->repository->update($id, $sanitized)) {
            throw new \RuntimeException('Failed to update car');
        }

        $car = $this->repository->findById($id);
        if ($car === null) {
            throw new \RuntimeException('Failed to retrieve updated car');
        }

        return $car;
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getPaginationInfo(int $page, int $perPage, array $criteria = []): array
    {
        $total = $this->getTotalCount($criteria);
        $totalPages = (int)ceil($total / $perPage);

        return [
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages,
            'has_next' => $page < $totalPages,
            'has_prev' => $page > 1
        ];
    }
}
