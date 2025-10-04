<?php

namespace App\Infrastructure\Http\Controllers\Api;

// UseCases
use App\Application\UseCases\Ad\CreateAd;
use App\Application\UseCases\Ad\ListAds;

// Requests
use App\Infrastructure\Http\Requests\CreateAdRequest;
use App\Infrastructure\Http\Requests\ListAdsRequest;

// Responses
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

// Controller
use Illuminate\Routing\Controller;


class AdController extends Controller
{
    public function __construct(
        private CreateAd $createAd,
        private ListAds $listAds
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

    public function list(ListAdsRequest $request): JsonResponse
    {
        try {
            $ads = $this->listAds->execute($request->getFilterParams());

            return response()->json($ads, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ad listing failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
