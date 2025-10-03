<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Application\UseCases\Ad\CreateAd;
use App\Infrastructure\Http\Requests\CreateAdRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdController extends Controller
{
    public function __construct(
        private CreateAd $createAd
    ) {}

    public function store(CreateAdRequest $request): JsonResponse
    {
        try {
            $ad = $this->createAd->execute(
                array_merge($request->validated(), [
                    'user_id' => $request->user()->id,
                ])
            );

            return response()->json([
                'message' => 'Ad created successfully',
                'ad' => $ad,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ad creation failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
