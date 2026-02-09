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
}
