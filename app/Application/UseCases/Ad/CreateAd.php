<?php

namespace App\Application\UseCases\Ad;

use App\Domain\Ad\Models\Ad;
use App\Domain\Ad\Repositories\AdRepositoryInterface;
use App\Infrastructure\Services\GeminiService;

class CreateAd
{
    public function __construct(
        private AdRepositoryInterface $adRepository,
        private GeminiService $geminiService
    ) {}

    public function execute(array $data): Ad
    {
        $ad = $this->adRepository->create($data);
        
        $ad->load(['category', 'user']);
        
        $aiData = $this->geminiService->enrichAdWithAI([
            'category_name' => $ad->category->name,
            'title' => $ad->title,
            'condition' => $ad->condition,
            'price' => $ad->price,
            'description' => $ad->description ?? '',
        ]);
        
        $ad->update($aiData);
        
        return $ad->fresh(['category', 'user']);
    }

}
