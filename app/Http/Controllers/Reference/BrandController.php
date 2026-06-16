<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\DTOs\BrandDTO;
use App\Services\BrandCRUDService;
use App\Http\Requests\StoreBrandRequest;

class BrandController extends Controller
{
    private BrandCRUDService $brandCRUDService;

    public function __construct(BrandCRUDService $brandCRUDService)
    {
        $this->brandCRUDService = $brandCRUDService;
    }

    public function __invoke()
    {
        $search = request('search');
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('reference.brands', $this->brandCRUDService->read($page, (int) $perPage, (int) session('user_id'), $search));
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandCRUDService->create(new BrandDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/brands')->with('success', 'Brand added successfully!');
    }

    public function update(StoreBrandRequest $request, int $id)
    {
        $this->brandCRUDService->update($id, new BrandDTO(...$request->validated()));
        return redirect('/brands')->with('success', 'Brand updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->brandCRUDService->delete($id);
        return redirect('/brands')->with('success', 'Brand deleted successfully!');
    }
}
