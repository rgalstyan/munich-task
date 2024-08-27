<?php

declare(strict_types=1);

namespace App\Repository;

use App\Formatters\Interfaces\ProductRequestFormatterInterface;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getProductWithSettings(int $id): Product|false;

    public function getFilteredProducts(ProductRequestFormatterInterface $filters): LengthAwarePaginator;

    public function existProductSku(string $sku): bool;
}
