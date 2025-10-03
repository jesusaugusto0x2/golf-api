<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:1'],
            'condition' => ['required', 'string', 'in:new,used,refurbished,like_new'],
            'description' => ['nullable', 'string'],
            'ends_at' => ['required', 'date', 'after:today'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title mus not exceed 255 characters',

            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 1',

            'condition.required' => 'Condition is required',
            'condition.string' => 'Condition must be a string',
            'condition.in' => 'Condition must be one of: new, used, refurbished, like_new',

            'ends_at.required' => 'Ends at is required',
            'ends_at.date' => 'Ends at must be a date',
            'ends_at.after' => 'Ends at must be in the future',

            'category_id.required' => 'Category id is required',
            'category_id.exists' => 'Category id must exist in the categories table',
        ];
    }
}
