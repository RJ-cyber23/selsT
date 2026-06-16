<?php

namespace App\Services;

use App\DTOs\UnitOfMeasureDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\UnitOfMeasureRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class UnitOfMeasureCRUDService
{
    public function __construct(
        protected UnitOfMeasureRepository $uomRepository,
    ) {}

    public function read(int $page = 1, int $perPage = 10, int $userId, ?string $search = null)
    {
        $result = $this->uomRepository->getAll($page, $perPage, $userId, $search);
        return [
            'uoms' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'search' => $search,
        ];
    }

    public function create(UnitOfMeasureDTO $dto, int $userId)
    {
        try {
            DB::insert("INSERT INTO Unit_of_Measure (uom_name, user_id) VALUES (?, ?)", [$dto->uom_name, $userId]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to add UOM. Please check the data and try again.');
        }
    }

    public function update(int $id, UnitOfMeasureDTO $dto)
    {
        try {
            DB::update("UPDATE Unit_of_Measure SET uom_name = ? WHERE uom_id = ?", [$dto->uom_name, $id]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update UOM. Please check the data and try again.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Unit_of_Measure WHERE uom_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this UOM is linked to existing products.');
            }
            throw new ServiceException('Failed to delete UOM.');
        }
    }
}
