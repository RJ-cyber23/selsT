<?php

namespace App\Services;

use App\DTOs\ProductDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ProductCRUDService
{
    public function __construct(
        protected ProductRepository $productRepository,
    ) {}

    public function read(?string $search = null, int $page = 1, int $perPage = 10, int $userId)
    {
        $result = $this->productRepository->getProductsWithDetails($search, $page, $perPage, $userId);
        return [
            'search' => $search,
            'products' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'categories' => $this->productRepository->getCategories($userId),
            'brands' => $this->productRepository->getBrands($userId),
            'suppliers' => $this->productRepository->getSuppliers($userId),
            'uoms' => $this->productRepository->getUnitOfMeasures($userId),
        ];
    }

    public function create(ProductDTO $dto, int $userId)
    {
        try {
            DB::insert("
                INSERT INTO Products (product_name, category_id, size, quantity, uom_id, weight, supplier_id, brand_id, mark_up, cost_price, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ", [
                $dto->product_name,
                $dto->category_id,
                $dto->size,
                $dto->quantity,
                $dto->uom_id,
                $dto->weight,
                $dto->supplier_id,
                $dto->brand_id,
                $dto->mark_up,
                $dto->cost_price,
                $userId,
            ]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to add product. Please check the data and try again.');
        }
    }

    public function update(int $id, ProductDTO $dto)
    {
        try {
            DB::update("
                UPDATE Products SET
                    product_name = ?, category_id = ?, size = ?, quantity = ?,
                    uom_id = ?, weight = ?, supplier_id = ?, brand_id = ?,
                    mark_up = ?, cost_price = ?
                WHERE product_id = ?
            ", [
                $dto->product_name,
                $dto->category_id,
                $dto->size,
                $dto->quantity,
                $dto->uom_id,
                $dto->weight,
                $dto->supplier_id,
                $dto->brand_id,
                $dto->mark_up,
                $dto->cost_price,
                $id,
            ]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update product. Please check the data and try again.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Products WHERE product_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this product is linked to existing sales.');
            }
            throw new ServiceException('Failed to delete product.');
        }
    }
}
