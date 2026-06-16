<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class SalesRepository
{
    public function getSalesWithDetails(?string $search = null, ?string $status = null, int $page = 1, int $perPage = 10, int $userId): array
    {
        $conditions = ['s.user_id = ?'];
        $countParams = [$userId];
        $dataParams = [$userId];

        if ($search) {
            $conditions[] = '(p.product_name LIKE ? OR (c.first_name || \' \' || c.last_name) LIKE ? OR CAST(s.sale_id AS TEXT) LIKE ? OR CAST(s.product_id AS TEXT) LIKE ?)';
            $countParams[] = "%{$search}%";
            $countParams[] = "%{$search}%";
            $countParams[] = "%{$search}%";
            $countParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
            $dataParams[] = "%{$search}%";
        }

        if ($status) {
            $conditions[] = 's.status = ?';
            $countParams[] = $status;
            $dataParams[] = $status;
        }

        $where = 'WHERE ' . implode(' AND ', $conditions);

        $total = DB::select("
            SELECT COUNT(*) AS count
            FROM Sales s
            LEFT JOIN Products p ON s.product_id = p.product_id
            LEFT JOIN Customers c ON s.customer_id = c.customer_id
            {$where}
        ", $countParams)[0]->count;

        $offset = ($page - 1) * $perPage;
        $dataParams[] = $perPage;
        $dataParams[] = $offset;

        $data = DB::select("
            SELECT
                s.sale_id, s.product_id, s.customer_id, s.quantity, s.status,
                p.product_name,
                c.first_name || ' ' || c.last_name AS customer_name,
                cat.category_name, b.brand_name, u.uom_name,
                (p.cost_price + p.mark_up) AS unit_price,
                (s.quantity * (p.cost_price + p.mark_up)) AS total_unitPrice,
                p.cost_price, p.mark_up
            FROM Sales s
            LEFT JOIN Products p ON s.product_id = p.product_id
            LEFT JOIN Customers c ON s.customer_id = c.customer_id
            LEFT JOIN Categories cat ON p.category_id = cat.category_id
            LEFT JOIN Brands b ON p.brand_id = b.brand_id
            LEFT JOIN Unit_of_Measure u ON p.uom_id = u.uom_id
            {$where}
            ORDER BY s.sale_id DESC LIMIT ? OFFSET ?
        ", $dataParams);

        return ['data' => $data, 'total' => $total];
    }

    public function getCustomers(int $userId)
    {
        return DB::select("
            SELECT customer_id, first_name || ' ' || last_name AS customer_name
            FROM Customers WHERE user_id = ? ORDER BY customer_name
        ", [$userId]);
    }

    public function getProducts(int $userId)
    {
        return DB::select("
            SELECT product_id, product_name FROM Products WHERE user_id = ? ORDER BY product_name
        ", [$userId]);
    }
}
