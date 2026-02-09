<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Repository\CarRepository;
use App\Database\Database;

/**
 * @group integration
 * @requires extension pdo_mysql
 */
class CarRepositoryTest extends TestCase
{
    private CarRepository $repository;

    protected function setUp(): void
    {
        try {
            Database::getConnection();
        } catch (\Exception $e) {
            $this->markTestSkipped('Database not available: ' . $e->getMessage());
        }
        
        $this->repository = new CarRepository();
    }

    public function testCreateAndFindCar(): void
    {
        $data = [
            'brand' => 'TestBrand',
            'model' => 'TestModel',
            'price' => 1000000,
            'year' => 2023,
            'color' => 'Red'
        ];

        $id = $this->repository->create($data);
        $this->assertGreaterThan(0, $id);

        $car = $this->repository->findById($id);
        $this->assertNotNull($car);
        $this->assertEquals('TestBrand', $car['brand']);

        $this->repository->delete($id);
    }

    public function testSearchCars(): void
    {
        $criteria = ['brand' => 'Toyota'];
        $results = $this->repository->search($criteria, 10, 0);
        $this->assertIsArray($results);
    }

    public function testPagination(): void
    {
        $cars = $this->repository->findAll(5, 0);
        $this->assertLessThanOrEqual(5, count($cars));
    }
}
