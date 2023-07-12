<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getStoreResponse(JsonResource $object): JsonResponse
    {
        return $object->response()
            ->setStatusCode(201);
    }

    public function getNoContentResponse(): Response
    {
        return response(null, 204);
    }

    public function getSuccessResponse(JsonResource $object): JsonResponse
    {
        return $object->response()
            ->setStatusCode(200);
    }
}
