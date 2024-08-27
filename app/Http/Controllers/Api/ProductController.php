<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\FilteredProductsRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService
    ) {
    }

    public function index(FilteredProductsRequest $request): AnonymousResourceCollection|JsonResponse
    {
        $products = $this->productService->index($request->validated());
        if($products) {
            return ProductResource::collection($products);
        }
        return $this->response400();
    }

    public function store(ProductStoreRequest $request): ProductResource|JsonResponse
    {
        $product = $this->productService->store($request->validated());
        if($product) {
            return ProductResource::make($product);
        }
        return $this->response400();
    }

    public function show(int $id): ProductResource|JsonResponse
    {
        $product = $this->productService->show($id);

        if($product) {
            return ProductResource::make($product);
        }
        return $this->response404();
    }

    public function update(ProductUpdateRequest $request, Product $product): ProductResource|JsonResponse
    {
        $this->authorize('update', $product);

        $product = $this->productService->update($product, $request->validated());
        if($product) {
            return $this->response200('Product updated successfully');
        }
        return $this->response404();
    }

    public function destroy(Product $product): JsonResponse
    {
        $this->authorize('destroy', $product);

        if($this->productService->destroy($product)) {
            return $this->response200('Product deleted successfully');
        }
        return $this->response404();
    }
}
