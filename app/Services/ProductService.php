<?php

declare(strict_types=1);

namespace App\Services;

use App\Formatters\Interfaces\ProductRequestFormatterInterface;
use App\Models\Product;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final readonly class ProductService
{
    public function __construct(
        private ProductRepositoryInterface       $productRepository,
        private ProductRequestFormatterInterface $productRequestFormatter,
    ){
    }

    /**
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function index(array $filters): LengthAwarePaginator
    {
        $formatedFilters = ($this->productRequestFormatter)($filters);
        return $this->productRepository->getFilteredProducts($formatedFilters);
    }

    /**
     * @param array $data (Validated request)
     * @return object|false
     */
    public function store(array $data): object|false
    {
        try {
            $data['user_id'] = 1;
            DB::beginTransaction();
            $product = $this->productRepository->create($data);
            DB::commit();
            return $product->load([
                'category',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }

    /**
     * @param int $id
     * @return Product|false
     */
    public function show(int $id): Product|false
    {
        try {
            return $this->productRepository->getProductWithSettings($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
        return false;
    }

    /**
     * @param Product $product
     * @param array $data (Validated request)
     * @return bool
     */
    public function update(Product $product, array $data): bool
    {
        try {
            DB::beginTransaction();

            $product->update($data);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }

    public function destroy(Product $product): bool
    {
        try {
            DB::beginTransaction();

            $product->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }

        return false;
    }
}
