<?php

namespace App\Services;

use App\DTOs\CustomerDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\CustomerRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CustomerCRUDService
{
    public function __construct(
        protected CustomerRepository $customerRepository,
    ) {}

    public function read(int $page = 1, int $perPage = 10, int $userId, ?string $search = null)
    {
        $result = $this->customerRepository->getAll($page, $perPage, $userId, $search);
        return [
            'customers' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'search' => $search,
        ];
    }

    public function create(CustomerDTO $dto, int $userId)
    {
        try {
            DB::insert("
                INSERT INTO Customers (first_name, last_name, bod, phone_number, Gmail, location_address, user_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ", [
                $dto->first_name, $dto->last_name, $dto->bod,
                $dto->phone_number, $dto->Gmail, $dto->location_address,
                $userId,
            ]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to add customer. Please check the data and try again.');
        }
    }

    public function update(int $id, CustomerDTO $dto)
    {
        try {
            DB::update("
                UPDATE Customers SET first_name = ?, last_name = ?, bod = ?,
                    phone_number = ?, Gmail = ?, location_address = ?
                WHERE customer_id = ?
            ", [
                $dto->first_name, $dto->last_name, $dto->bod,
                $dto->phone_number, $dto->Gmail, $dto->location_address,
                $id,
            ]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update customer. Please check the data and try again.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Customers WHERE customer_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this customer is linked to existing sales.');
            }
            throw new ServiceException('Failed to delete customer.');
        }
    }
}
