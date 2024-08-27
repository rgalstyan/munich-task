<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Formatters\Interfaces\ProductRequestFormatterInterface;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(
        Product $model
    ) {
        parent::__construct($model);
    }

    public function getProductWithSettings(int $id): Product|false
    {
        $product = $this->model->with([
            'category',
        ])->find($id);

        if (!$product) {
            return false;
        }

        return $product;
    }

    public function getFilteredProducts(ProductRequestFormatterInterface $filters): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if($filters->getUserId()) {
            $this->applyUserFilter($query, $filters->getUserId());
        }

        if($filters->getCategoryId()) {
            $this->applyCategoryFilter($query, $filters->getCategoryId());
        }

        if($filters->getMinPrice()) {
            $this->applyMinPriceFilter($query, $filters->getMinPrice());
        }

        if($filters->getMaxPrice()) {
            $this->applyMaxPriceFilter($query, $filters->getMaxPrice());
        }

        if($filters->getSearch()) {
            $this->applySearchFilter($query, $filters->getSearch());
        }

        return $query->with([
            'category',
        ])->orderBy('created_at', 'DESC')->paginate($filters->getPerPage());

    }

    private function applyUserFilter($query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    private function applyCategoryFilter($query, int $categoryId): void
    {
        $query->where('category_id', $categoryId);
    }

    private function applyMinPriceFilter($query, float $minPrice): void
    {
        $query->where('price', '>=', $minPrice);
    }

    private function applyMaxPriceFilter($query, float $maxPrice): void
    {
        $query->where('price', '<=', $maxPrice);
    }

    private function applySearchFilter($query, string $search): void
    {
        $search = '%'.$search.'%';

        $query->where(function ($query) use($search) {
            $query->where('title', 'like', $search)
                ->orWhere('description', 'like', $search)
                ->orWhereHas('category', function ($q) use($search) {
                    $q->where('title', 'like', $search);
                });
        });

    }

    public function existProductSku(string $sku): bool
    {
        $count = $this->model->where('sku', $sku)->count();

        return $count > 0;
    }
}
