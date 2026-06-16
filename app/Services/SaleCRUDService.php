<?php

namespace App\Services;

use App\DTOs\SaleDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\SalesRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class SaleCRUDService
{
    public function __construct(
        protected SalesRepository $salesRepository,
    ) {}

    public function read(?string $search = null, ?string $status = null, int $page = 1, int $perPage = 10, int $userId)
    {
        $result = $this->salesRepository->getSalesWithDetails($search, $status, $page, $perPage, $userId);
        return [
            'search' => $search,
            'status' => $status,
            'sales' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'customers' => $this->salesRepository->getCustomers($userId),
            'products' => $this->salesRepository->getProducts($userId),
        ];
    }

    public function create(SaleDTO $dto, int $userId)
    {
        try {
            DB::insert("
                INSERT INTO Sales (product_id, customer_id, quantity, status, user_id)
                VALUES (?, ?, ?, 'completed', ?)
            ", [
                $dto->product_id,
                $dto->customer_id,
                $dto->quantity,
                $userId,
            ]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to record sale. Please check the data and try again.');
        }
    }

    public function update(int $id, SaleDTO $dto)
    {
        try {
            DB::update("
                UPDATE Sales SET product_id = ?, customer_id = ?, quantity = ?
                WHERE sale_id = ?
            ", [
                $dto->product_id,
                $dto->customer_id,
                $dto->quantity,
                $id,
            ]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update sale. Please check the data and try again.');
        }
    }

    public function cancel(int $id)
    {
        try {
            DB::update("UPDATE Sales SET status = 'cancelled' WHERE sale_id = ?", [$id]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to cancel sale.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Sales WHERE sale_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this sale is referenced by other records.');
            }
            throw new ServiceException('Failed to delete sale.');
        }
    }
}
