<?php

namespace App\Models\Repositories;

use Illuminate\Support\Facades\DB;

class ProductAnalyticsRepository
{
    public function getTotals(int $userId)
    {
        return DB::selectOne("
            SELECT
                SUM(cost_price) AS total_cost,
                SUM(mark_up) AS total_markup,
                SUM(cost_price + mark_up) AS total_unitPrice
            FROM Products WHERE user_id = ?
        ", [$userId]);
    }

    public function getSalesTotals(int $userId)
    {
        return DB::selectOne("
            SELECT
                COUNT(*) AS total_sales,
                SUM(s.quantity * p.cost_price) AS total_cost,
                SUM(s.quantity * p.mark_up) AS total_markup,
                SUM(s.quantity * (p.cost_price + p.mark_up)) AS total_unitPrice
            FROM Sales s
            LEFT JOIN Products p ON s.product_id = p.product_id
            WHERE s.user_id = ?
        ", [$userId]);
    }
}
