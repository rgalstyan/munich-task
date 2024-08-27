<?php

namespace App\Helpers;

use App\Repository\ProductRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

final class Helpers
{
    public static function generateSku(ProductRepositoryInterface $productRepository): string
    {
        do {
            $sku = Str::random(8);
            $existSku = $productRepository->existProductSku($sku);
        } while ($existSku);

        return $sku;
    }

    public static function generateResponse(string $message, $status): JsonResponse
    {
        return response()->json(['message' => $message], $status);
    }
}
