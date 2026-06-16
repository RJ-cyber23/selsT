<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function getProductsWithDetails(?string $search = null, int $page = 1, int $perPage = 10, int $userId): array
    {
        $conditions = 'WHERE p.user_id = ?';
        $countParams = [$userId];
        $dataParams = [$userId];

        if ($search) {
            $conditions .= ' AND (p.product_name LIKE ? OR CAST(p.product_id AS TEXT) LIKE ?)';
            $countParams[] = "%{$search}%";
            $countParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
        }

        $total = DB::select("SELECT COUNT(*) AS count FROM Products p {$conditions}", $countParams)[0]->count;

        $offset = ($page - 1) * $perPage;
        $dataParams[] = $perPage;
        $dataParams[] = $offset;

        $data = DB::select("
            SELECT
                p.product_id, p.product_name, p.category_id, p.size, p.quantity,
                p.uom_id, p.weight, p.supplier_id, p.brand_id, p.cost_price, p.mark_up,
                (p.mark_up + p.cost_price) AS unitPrice,
                c.category_name, u.uom_name, b.brand_name
            FROM Products p
            LEFT JOIN Categories c ON p.category_id = c.category_id AND c.user_id = ?
            LEFT JOIN Unit_of_Measure u ON p.uom_id = u.uom_id AND u.user_id = ?
            LEFT JOIN Brands b ON p.brand_id = b.brand_id AND b.user_id = ?
            {$conditions}
            ORDER BY p.product_name LIMIT ? OFFSET ?
        ", array_merge([$userId, $userId, $userId], $dataParams));

        return ['data' => $data, 'total' => $total];
    }

    public function getCategories(int $userId)
    {
        return DB::select("SELECT category_id, category_name FROM Categories WHERE user_id = ? ORDER BY category_name", [$userId]);
    }

    public function getBrands(int $userId)
    {
        return DB::select("SELECT brand_id, brand_name FROM Brands WHERE user_id = ? ORDER BY brand_name", [$userId]);
    }

    public function getSuppliers(int $userId)
    {
        return DB::select("SELECT supplier_id, first_name || ' ' || last_name AS supplier_name FROM Suppliers WHERE user_id = ? ORDER BY supplier_name", [$userId]);
    }

    public function getUnitOfMeasures(int $userId)
    {
        return DB::select("SELECT uom_id, uom_name FROM Unit_of_Measure WHERE user_id = ? ORDER BY uom_name", [$userId]);
    }
}
