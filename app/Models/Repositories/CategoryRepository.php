<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function getAll(int $page = 1, int $perPage = 10, int $userId, ?string $search = null): array
    {
        $params = [$userId];
        $searchCondition = '';
        if ($search) {
            $searchCondition = ' AND category_name LIKE ?';
            $params[] = "%{$search}%";
        }
        $offset = ($page - 1) * $perPage;
        $total = DB::select("SELECT COUNT(*) AS count FROM Categories WHERE user_id = ?{$searchCondition}", $params)[0]->count;
        $dataParams = array_merge($params, [$perPage, $offset]);
        $data = DB::select("SELECT * FROM Categories WHERE user_id = ?{$searchCondition} ORDER BY category_name LIMIT ? OFFSET ?", $dataParams);
        return ['data' => $data, 'total' => $total];
    }

    public function getAllUnpaginated(int $userId)
    {
        return DB::select("SELECT * FROM Categories WHERE user_id = ? ORDER BY category_name", [$userId]);
    }
}
