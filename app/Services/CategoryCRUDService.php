<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Exceptions\ServiceException;
use App\Models\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class CategoryCRUDService
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {}

    public function read(int $page = 1, int $perPage = 10, int $userId, ?string $search = null)
    {
        $result = $this->categoryRepository->getAll($page, $perPage, $userId, $search);
        return [
            'categories' => $result['data'],
            'total' => $result['total'],
            'currentPage' => $page,
            'perPage' => $perPage,
            'lastPage' => (int) ceil($result['total'] / max($perPage, 1)),
            'search' => $search,
        ];
    }

    public function create(CategoryDTO $dto, int $userId)
    {
        try {
            DB::insert("INSERT INTO Categories (category_name, user_id) VALUES (?, ?)", [$dto->category_name, $userId]);
            return DB::getPdo()->lastInsertId();
        } catch (QueryException $e) {
            throw new ServiceException('Failed to add category. Please check the data and try again.');
        }
    }

    public function update(int $id, CategoryDTO $dto)
    {
        try {
            DB::update("UPDATE Categories SET category_name = ? WHERE category_id = ?", [$dto->category_name, $id]);
        } catch (QueryException $e) {
            throw new ServiceException('Failed to update category. Please check the data and try again.');
        }
    }

    public function delete(int $id)
    {
        try {
            DB::delete("DELETE FROM Categories WHERE category_id = ?", [$id]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                throw new ServiceException('Cannot delete: this category is linked to existing products.');
            }
            throw new ServiceException('Failed to delete category.');
        }
    }
}
