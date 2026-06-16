<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\DTOs\UnitOfMeasureDTO;
use App\Services\UnitOfMeasureCRUDService;
use App\Http\Requests\StoreUnitOfMeasureRequest;

class UnitOfMeasureController extends Controller
{
    private UnitOfMeasureCRUDService $uomCRUDService;

    public function __construct(UnitOfMeasureCRUDService $uomCRUDService)
    {
        $this->uomCRUDService = $uomCRUDService;
    }

    public function __invoke()
    {
        $search = request('search');
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('reference.uoms', $this->uomCRUDService->read($page, (int) $perPage, (int) session('user_id'), $search));
    }

    public function store(StoreUnitOfMeasureRequest $request)
    {
        $this->uomCRUDService->create(new UnitOfMeasureDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/uoms')->with('success', 'UOM added successfully!');
    }

    public function update(StoreUnitOfMeasureRequest $request, int $id)
    {
        $this->uomCRUDService->update($id, new UnitOfMeasureDTO(...$request->validated()));
        return redirect('/uoms')->with('success', 'UOM updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->uomCRUDService->delete($id);
        return redirect('/uoms')->with('success', 'UOM deleted successfully!');
    }
}
