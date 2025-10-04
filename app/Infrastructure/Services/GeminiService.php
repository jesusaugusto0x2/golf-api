<?php

namespace App\Infrastructure\Services;

use Gemini\Data\GenerationConfig;
use Gemini\Data\Schema;
use Gemini\Enums\DataType;
use Gemini\Enums\ResponseMimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function enrichAdWithAI(array $adData): array
    {
        try {
            $prompt = $this->buildPrompt($adData);
            
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                ->withGenerationConfig(
                    generationConfig: new GenerationConfig(
                        responseMimeType: ResponseMimeType::APPLICATION_JSON,
                        responseSchema: new Schema(
                            type: DataType::OBJECT,
                            properties: [
                                'valuation' => new Schema(type: DataType::STRING),
                                'estimated_price' => new Schema(type: DataType::NUMBER)
                            ],
                            required: ['valuation', 'estimated_price'],
                        )
                    )
                )
                ->generateContent($prompt);
            
            $jsonResponse = $result->json();
            
            return [
                'ai_valuation' => $jsonResponse->valuation ?? null,
                'estimated_market_price' => $jsonResponse->estimated_price ?? null,
            ];
            
        } catch (\Exception $e) {
            Log::error('Gemini AI enrichment failed', [
                'error' => $e->getMessage(),
                'ad_data' => $adData
            ]);
            
            return [
                'ai_valuation' => null,
                'estimated_market_price' => null,
            ];
        }
    }

    private function buildPrompt(array $adData): string
    {
        // Base del prompt con info obligatoria
        $prompt = "You are a golf equipment expert with deep knowledge of market prices and equipment quality. Analyze this golf equipment listing:
            Category: {$adData['category_name']}
            Title: {$adData['title']}
            Condition: {$adData['condition']}
            User's asking price: \${$adData['price']}
        ";

        if (!empty($adData['description'])) {
            $prompt .= "\nAdditional details: {$adData['description']}";
        }

        $prompt .= "

            Here are some examples of good valuations:

            Example 1:
            Title: TaylorMade M4 Driver
            Condition: used
            Asking price: \$350
            Response: {
            \"valuation\": \"The TaylorMade M4 Driver (2018) features Twist Face technology for improved accuracy on off-center hits. It's a game-improvement driver popular among mid-to-high handicappers seeking distance and forgiveness. Known for its reliable performance and durability.\",
            \"estimated_price\": 245
            }

            Example 2:
            Title: Titleist 718 AP1 Irons Set (4-PW)
            Condition: like_new
            Asking price: \$650
            Response: {
            \"valuation\": \"The Titleist 718 AP1 irons are premium game-improvement irons released in 2017. They offer exceptional distance and forgiveness through their hollow-body construction while maintaining the classic Titleist feel. Highly regarded among players with 10-20 handicaps.\",
            \"estimated_price\": 580
            }

            Example 3:
            Title: Odyssey White Hot Pro Putter
            Condition: refurbished
            Asking price: \$120
            Response: {
            \"valuation\": \"The Odyssey White Hot Pro series is one of the most trusted putter lines on tour. The White Hot insert provides excellent feel and consistent roll. This model suits players of all levels seeking reliable performance on the greens.\",
            \"estimated_price\": 95
            }

            Now analyze the listing above and provide:
            1. \"valuation\": A professional assessment (2-3 sentences) covering: brand reputation, key features/technology, and target player level
            2. \"estimated_price\": A realistic current market price (number only, in USD) based on the condition

            Be accurate, concise, and professional.
        ";

        return $prompt;
    }
}