<?php

namespace App\Infrastructure\Http\Controllers\Api;

// UseCases
use App\Application\UseCases\Ad\CreateAd;
use App\Application\UseCases\Ad\ListAds;
use App\Application\UseCases\Ad\DeleteAd;

// Requests
use Illuminate\Http\Request;
use App\Infrastructure\Http\Requests\CreateAdRequest;
use App\Infrastructure\Http\Requests\ListAdsRequest;

// Resources
use App\Infrastructure\Http\Resources\AdResource;

// Responses
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

// Controller
use Illuminate\Routing\Controller;


class AdController extends Controller
{
    public function __construct(
        private CreateAd $createAd,
        private ListAds $listAds,
        private DeleteAd $deleteAd
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

            return AdResource::collection($ads)->response();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ad listing failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete(int $adId, Request $request): Response|JsonResponse
    {
        try {
            $this->deleteAd->execute($adId, $request->user()->id);
    
            return response()->noContent();
        } catch (HttpException $e) {
            return response()->json([
                'message' => 'Ad deletion failed',
                'error' => $e->getMessage(),
            ], $e->getStatusCode());
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ad deletion failed',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
