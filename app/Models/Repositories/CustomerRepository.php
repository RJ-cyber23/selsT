<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function getAll(int $page = 1, int $perPage = 10, int $userId, ?string $search = null): array
    {
        $params = [$userId];
        $searchCondition = '';
        if ($search) {
            $searchCondition = ' AND (first_name || \' \' || last_name LIKE ? OR first_name LIKE ? OR last_name LIKE ?)';
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        $offset = ($page - 1) * $perPage;
        $total = DB::select("SELECT COUNT(*) AS count FROM Customers WHERE user_id = ?{$searchCondition}", $params)[0]->count;
        $dataParams = array_merge($params, [$perPage, $offset]);
        $data = DB::select("SELECT * FROM Customers WHERE user_id = ?{$searchCondition} ORDER BY first_name LIMIT ? OFFSET ?", $dataParams);
        return ['data' => $data, 'total' => $total];
    }

    public function getAllUnpaginated(int $userId)
    {
        return DB::select("SELECT * FROM Customers WHERE user_id = ? ORDER BY first_name", [$userId]);
    }
}
