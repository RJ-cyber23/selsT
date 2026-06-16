<?php

namespace App\Services;

use App\DTOs\BrandDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\BrandRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BrandCRUDService
{
    public function __construct(
        protected BrandRepository $brandRepository,
    ) {}

    public function read(int $page = 1, int $perPage = 10, int $userId, ?string $search = null)
    {
        $result = $this->brandRepository->getAll($page, $perPage, $userId, $search);
        return [
            'brands' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'search' => $search,
        ];
    }

    public function create(BrandDTO $dto, int $userId)
    {
        try {
            DB::insert("INSERT INTO Brands (brand_name, user_id) VALUES (?, ?)", [$dto->brand_name, $userId]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to add brand. Please check the data and try again.');
        }
    }

    public function update(int $id, BrandDTO $dto)
    {
        try {
            DB::update("UPDATE Brands SET brand_name = ? WHERE brand_id = ?", [$dto->brand_name, $id]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update brand. Please check the data and try again.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Brands WHERE brand_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this brand is linked to existing products.');
            }
            throw new ServiceException('Failed to delete brand.');
        }
    }
}
