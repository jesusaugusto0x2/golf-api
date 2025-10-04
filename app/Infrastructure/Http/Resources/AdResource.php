<?php

namespace App\Infrastructure\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => (float) $this->price,
            'condition' => $this->condition,
            'description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'ai_valuation' => $this->ai_valuation,
            'estimated_market_price' => (float) $this->estimated_market_price,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'lastname' => $this->user->lastname,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
        ];
    }
}
