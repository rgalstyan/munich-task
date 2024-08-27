<?php

namespace App\Observers;

use App\Helpers\Helpers;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;

final class ProductObserver
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function creating(Product $product): void
    {
        $product->sku = Helpers::generateSku($this->productRepository);
    }
}
