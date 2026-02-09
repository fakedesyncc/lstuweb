<?php

namespace App\Repository;

use App\Database\Database;
use PDO;

/**
 * @author fakedesyncc
 */
class CarRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findAll(?int $limit = null, int $offset = 0): array
    {
        $sql = "SELECT * FROM cars ORDER BY created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findByUserId(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE client_id = :userId ORDER BY created_at DESC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll();
    }

    public function findByBrandAndModel(string $brand, string $model): array
    {
        $stmt = $this->db->prepare("SELECT * FROM cars WHERE brand = :brand AND model = :model LIMIT 1");
        $stmt->execute([':brand' => $brand, ':model' => $model]);
        return $stmt->fetchAll();
    }

    public function search(array $criteria, ?int $limit = null, int $offset = 0): array
    {
        $conditions = [];
        $params = [];

        if (!empty($criteria['brand'])) {
            $conditions[] = "brand LIKE :brand";
            $params[':brand'] = '%' . $criteria['brand'] . '%';
        }

        if (!empty($criteria['model'])) {
            $conditions[] = "model LIKE :model";
            $params[':model'] = '%' . $criteria['model'] . '%';
        }

        if (isset($criteria['minPrice'])) {
            $conditions[] = "price >= :minPrice";
            $params[':minPrice'] = $criteria['minPrice'];
        }

        if (isset($criteria['maxPrice'])) {
            $conditions[] = "price <= :maxPrice";
            $params[':maxPrice'] = $criteria['maxPrice'];
        }

        if (isset($criteria['minYear'])) {
            $conditions[] = "year >= :minYear";
            $params[':minYear'] = $criteria['minYear'];
        }

        if (isset($criteria['maxYear'])) {
            $conditions[] = "year <= :maxYear";
            $params[':maxYear'] = $criteria['maxYear'];
        }

        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "SELECT * FROM cars {$where} ORDER BY created_at DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
            $params[':limit'] = $limit;
            $params[':offset'] = $offset;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function count(array $criteria = []): int
    {
        $conditions = [];
        $params = [];

        if (!empty($criteria['brand'])) {
            $conditions[] = "brand LIKE :brand";
            $params[':brand'] = '%' . $criteria['brand'] . '%';
        }

        if (!empty($criteria['model'])) {
            $conditions[] = "model LIKE :model";
            $params[':model'] = '%' . $criteria['model'] . '%';
        }

        if (isset($criteria['minPrice'])) {
            $conditions[] = "price >= :minPrice";
            $params[':minPrice'] = $criteria['minPrice'];
        }

        if (isset($criteria['maxPrice'])) {
            $conditions[] = "price <= :maxPrice";
            $params[':maxPrice'] = $criteria['maxPrice'];
        }

        $where = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';
        $sql = "SELECT COUNT(*) as total FROM cars {$where}";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return (int)($result['total'] ?? 0);
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO cars (brand, model, price, year, color, image_url, client_id) 
                VALUES (:brand, :model, :price, :year, :color, :image_url, :client_id)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':brand' => $data['brand'],
            ':model' => $data['model'],
            ':price' => $data['price'],
            ':year' => $data['year'],
            ':color' => $data['color'] ?? null,
            ':image_url' => $data['image_url'] ?? null,
            ':client_id' => $data['client_id'] ?? null
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $fields = [];
        $params = [':id' => $id];
        
        if (isset($data['brand'])) {
            $fields[] = 'brand = :brand';
            $params[':brand'] = $data['brand'];
        }
        if (isset($data['model'])) {
            $fields[] = 'model = :model';
            $params[':model'] = $data['model'];
        }
        if (isset($data['price'])) {
            $fields[] = 'price = :price';
            $params[':price'] = $data['price'];
        }
        if (isset($data['year'])) {
            $fields[] = 'year = :year';
            $params[':year'] = $data['year'];
        }
        if (isset($data['color'])) {
            $fields[] = 'color = :color';
            $params[':color'] = $data['color'];
        }
        if (isset($data['image_url'])) {
            $fields[] = 'image_url = :image_url';
            $params[':image_url'] = $data['image_url'];
        }
        
        if (empty($fields)) {
            return false;
        }
        
        $sql = "UPDATE cars SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM cars WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
