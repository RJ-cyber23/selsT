<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use App\DTOs\CategoryDTO;
use App\Services\CategoryCRUDService;
use App\Http\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{
    private CategoryCRUDService $categoryCRUDService;

    public function __construct(CategoryCRUDService $categoryCRUDService)
    {
        $this->categoryCRUDService = $categoryCRUDService;
    }

    public function __invoke()
    {
        $search = request('search');
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('reference.categories', $this->categoryCRUDService->read($page, (int) $perPage, (int) session('user_id'), $search));
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryCRUDService->create(new CategoryDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/categories')->with('success', 'Category added successfully!');
    }

    public function update(StoreCategoryRequest $request, int $id)
    {
        $this->categoryCRUDService->update($id, new CategoryDTO(...$request->validated()));
        return redirect('/categories')->with('success', 'Category updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->categoryCRUDService->delete($id);
        return redirect('/categories')->with('success', 'Category deleted successfully!');
    }
}
