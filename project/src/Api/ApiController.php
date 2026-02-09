<?php

namespace App\Api;

use App\Service\CarService;
use App\Service\UserService;
use App\Logger\Logger;

/**
 * @author fakedesyncc
 */
class ApiController
{
    private CarService $carService;
    private UserService $userService;
    private Logger $logger;

    public function __construct()
    {
        $this->carService = new CarService();
        $this->userService = new UserService();
        $this->logger = new Logger('api');
    }

    public function handleRequest(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
        $pathStr = is_string($path) ? $path : '';
        $pathParts = explode('/', trim($pathStr, '/'));

        try {
            if ($pathParts[0] === 'api' && isset($pathParts[1])) {
                $resource = $pathParts[1];
                $id = $pathParts[2] ?? null;

                switch ($resource) {
                    case 'cars':
                        $this->handleCars($method, $id);
                        break;
                    case 'users':
                        $this->handleUsers($method, $id);
                        break;
                    default:
                        $this->sendError(404, 'Resource not found');
                }
            } else {
                $this->sendError(404, 'API endpoint not found');
            }
        } catch (\Exception $e) {
            $this->logger->error('API Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->sendError(500, $e->getMessage());
        }
    }

    public function getCars(): void
    {
        $page = (int)($_GET['page'] ?? 1);
        $perPage = (int)($_GET['per_page'] ?? 10);
        $criteria = $this->getSearchCriteria();

        $cars = $this->carService->search($criteria, $page, $perPage);
        $pagination = $this->carService->getPaginationInfo($page, $perPage, $criteria);

        $this->sendResponse([
            'data' => $cars,
            'pagination' => $pagination
        ]);
    }

    public function getCar(int $id): void
    {
        $car = $this->carService->getById($id);
        if ($car) {
            $this->sendResponse($car);
        } else {
            $this->sendError(404, 'Car not found');
        }
    }

    public function createCar(): void
    {
        $input = file_get_contents('php://input');
        if ($input === false) {
            $this->sendError(400, 'Invalid request body');
            return;
        }
        $data = json_decode($input, true);
        if ($data === null) {
            $this->sendError(400, 'Invalid JSON');
            return;
        }
        $car = $this->carService->create($data);
        http_response_code(201);
        $this->sendResponse($car);
    }

    public function updateCar(int $id): void
    {
        $input = file_get_contents('php://input');
        if ($input === false) {
            $this->sendError(400, 'Invalid request body');
            return;
        }
        $data = json_decode($input, true);
        if ($data === null) {
            $this->sendError(400, 'Invalid JSON');
            return;
        }
        $car = $this->carService->update($id, $data);
        $this->sendResponse($car);
    }

    public function deleteCar(int $id): void
    {
        $this->carService->delete($id);
        http_response_code(204);
    }

    private function handleCars(string $method, ?string $id): void
    {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $car = $this->carService->getById((int)$id);
                    if ($car) {
                        $this->sendResponse($car);
                    } else {
                        $this->sendError(404, 'Car not found');
                    }
                } else {
                    $page = (int)($_GET['page'] ?? 1);
                    $perPage = (int)($_GET['per_page'] ?? 10);
                    $criteria = $this->getSearchCriteria();

                    $cars = $this->carService->search($criteria, $page, $perPage);
                    $pagination = $this->carService->getPaginationInfo($page, $perPage, $criteria);

                    $this->sendResponse([
                        'data' => $cars,
                        'pagination' => $pagination
                    ]);
                }
                break;

            case 'POST':
                $input = file_get_contents('php://input');
                if ($input === false) {
                    $this->sendError(400, 'Invalid request body');
                    return;
                }
                $data = json_decode($input, true);
                if ($data === null) {
                    $this->sendError(400, 'Invalid JSON');
                    return;
                }
                $car = $this->carService->create($data);
                http_response_code(201);
                $this->sendResponse($car);
                break;

            case 'PUT':
            case 'PATCH':
                if (!$id) {
                    $this->sendError(400, 'ID required');
                    return;
                }
                $input = file_get_contents('php://input');
                if ($input === false) {
                    $this->sendError(400, 'Invalid request body');
                    return;
                }
                $data = json_decode($input, true);
                if ($data === null) {
                    $this->sendError(400, 'Invalid JSON');
                    return;
                }
                $car = $this->carService->update((int)$id, $data);
                $this->sendResponse($car);
                break;

            case 'DELETE':
                if (!$id) {
                    $this->sendError(400, 'ID required');
                    return;
                }
                $this->carService->delete((int)$id);
                http_response_code(204);
                break;

            default:
                $this->sendError(405, 'Method not allowed');
        }
    }

    private function handleUsers(string $method, ?string $id): void
    {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $user = $this->userService->getById((int)$id);
                    if ($user) {
                        $this->sendResponse($user);
                    } else {
                        $this->sendError(404, 'User not found');
                    }
                } else {
                    $this->sendError(403, 'Listing users is not allowed');
                }
                break;

            default:
                $this->sendError(405, 'Method not allowed');
        }
    }

    private function getSearchCriteria(): array
    {
        $criteria = [];

        if (isset($_GET['brand'])) {
            $criteria['brand'] = $_GET['brand'];
        }

        if (isset($_GET['model'])) {
            $criteria['model'] = $_GET['model'];
        }

        if (isset($_GET['min_price'])) {
            $criteria['minPrice'] = (float)$_GET['min_price'];
        }

        if (isset($_GET['max_price'])) {
            $criteria['maxPrice'] = (float)$_GET['max_price'];
        }

        if (isset($_GET['min_year'])) {
            $criteria['minYear'] = (int)$_GET['min_year'];
        }

        if (isset($_GET['max_year'])) {
            $criteria['maxYear'] = (int)$_GET['max_year'];
        }

        return $criteria;
    }

    /**
     * @param array<mixed>|object $data
     */
    private function sendResponse($data): void
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    private function sendError(int $code, string $message): void
    {
        http_response_code($code);
        echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
