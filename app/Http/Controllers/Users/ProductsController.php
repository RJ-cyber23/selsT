<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\DTOs\ProductDTO;
use App\Services\ProductCRUDService;
use App\Http\Requests\StoreProductRequest;

class ProductsController extends Controller
{
    private ProductCRUDService $productCRUDService;

    public function __construct(ProductCRUDService $productCRUDService)
    {
        $this->productCRUDService = $productCRUDService;
    }

    public function __invoke()
    {
        $perPage = request('perPage', 10);
        if ($perPage === 'all') { $perPage = 999999; }
        $page = max(1, (int) request('page', 1));
        return view('products', $this->productCRUDService->read(
            search: request('search'),
            page: $page,
            perPage: (int) $perPage,
            userId: (int) session('user_id'),
        ));
    }

    public function store(StoreProductRequest $request)
    {
        $this->productCRUDService->create(new ProductDTO(...$request->validated()), (int) session('user_id'));
        return redirect('/products')->with('success', 'Product added successfully!');
    }

    public function update(StoreProductRequest $request, int $id)
    {
        $this->productCRUDService->update($id, new ProductDTO(...$request->validated()));
        return redirect('/products')->with('success', 'Product updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->productCRUDService->delete($id);
        return redirect('/products')->with('success', 'Product deleted successfully!');
    }
}
