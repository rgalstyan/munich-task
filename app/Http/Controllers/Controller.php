<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response400(string $message = ''): JsonResponse
    {
        return Helpers::generateResponse($message ?? 'Server did not respond', ResponseAlias::HTTP_BAD_REQUEST);
    }

    public function response401(): JsonResponse
    {
        return Helpers::generateResponse('Invalid/Expired url provided.', ResponseAlias::HTTP_UNAUTHORIZED);
    }

    public function response200(string $message = ''): JsonResponse
    {
        return Helpers::generateResponse($message, ResponseAlias::HTTP_OK);
    }

    public function response404(): JsonResponse
    {
        return Helpers::generateResponse('Not Found', ResponseAlias::HTTP_NOT_FOUND);
    }
}
