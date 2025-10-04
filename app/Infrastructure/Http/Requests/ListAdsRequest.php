<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListAdsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price_min'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'condition' => ['nullable', 'string', 'in:new,used,refurbished,like_new'],
            'search' => ['nullable', 'string', 'max:255'],
            'show_all' => ['nullable', 'boolean'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'price_max.gte' => 'Maximum price must be greater than or equal to minimum price',
            'category_id.exists' => 'The selected category does not exist',
            'condition.in' => 'condition must be: new, used, refurbished, or like_new',
        ];
    }

    /**
     * Helper method to get validated parameters with defaults
     */
    public function getFilterParams(): array
    {
        $params = [
            'per_page' => $this->query('per_page', 10),
            'page' => $this->query('page', 1),
        ];

        // Solo agregar filtros si existen
        if ($this->filled('price_min')) {
            $params['price_min'] = $this->query('price_min');
        }

        if ($this->filled('price_max')) {
            $params['price_max'] = $this->query('price_max');
        }

        if ($this->filled('category_id')) {
            $params['category_id'] = $this->query('category_id');
        }

        if ($this->filled('condition')) {
            $params['condition'] = $this->query('condition');
        }

        if ($this->filled('search')) {
            $params['search'] = $this->query('search');
        }

        if ($this->has('show_all')) {
            $params['show_all'] = $this->boolean('show_all');
        }

        return $params;
    }
}
