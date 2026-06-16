<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Repositories\ProductAnalyticsRepository;

class HomeController extends Controller
{
    private ProductAnalyticsRepository $productAnalyticsRepository;

    public function __construct(ProductAnalyticsRepository $productAnalyticsRepository)
    {
        $this->productAnalyticsRepository = $productAnalyticsRepository;
    }

    public function __invoke()
    {
        if (!session('user_id')) {
            return view('landing');
        }

        $userId = (int) session('user_id');
        return view('dashboard', [
            'totals' => $this->productAnalyticsRepository->getTotals($userId),
            'salesTotals' => $this->productAnalyticsRepository->getSalesTotals($userId),
        ]);
    }
}
