<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\DTOs\SaleDTO;
use App\Services\SaleCRUDService;
use App\Http\Requests\StoreSaleRequest;

class SalesController extends Controller
{
    private SaleCRUDService $saleCRUDService;

    public function __construct(SaleCRUDService $saleCRUDService)
    {
        $this->saleCRUDService = $saleCRUDService;
    }

    public function __invoke()
    {
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('sales', $this->saleCRUDService->read(
            search: request('search'),
            status: request('status'),
            page: $page,
            perPage: (int) $perPage,
            userId: (int) session('user_id'),
        ));
    }

    public function store(StoreSaleRequest $request)
    {
        $this->saleCRUDService->create(new SaleDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/sales')->with('success', 'Sale recorded successfully!');
    }

    public function update(StoreSaleRequest $request, int $id)
    {
        $this->saleCRUDService->update($id, new SaleDTO(...$request->validated()));
        return redirect('/sales')->with('success', 'Sale updated successfully!');
    }

    public function cancel(int $id)
    {
        $this->saleCRUDService->cancel($id);
        return redirect('/sales')->with('success', 'Sale cancelled successfully!');
    }

    public function destroy(int $id)
    {
        $this->saleCRUDService->delete($id);
        return redirect('/sales')->with('success', 'Sale deleted successfully!');
    }
}
