<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Ad\Models\Ad;
use App\Domain\Ad\Repositories\AdRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentAdRepository implements AdRepositoryInterface
{
    public function create(array $data): Ad
    {
        return Ad::create($data);
    }

    public function list(array $params): Collection|LengthAwarePaginator
    {
        $query = Ad::query()->with('user', 'category');
        
        if (isset($params['show_all']) && $params['show_all'] === true) {
            $query->orderBy('price', 'desc');
        } else {
            $query->where('ends_at', '>', now())
                ->orderBy('created_at', 'asc');
        }

        if (isset($params['price_min'])) {
            $query->where('price', '>=', $params['price_min']);
        }

        if (isset($params['price_max'])) {
            $query->where('price', '<=', $params['price_max']);
        }

        if (isset($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (isset($params['condition'])) {
            $query->where('condition', $params['condition']);
        }

        if (isset($params['search'])) {
            $query->where(function ($q) use ($params) {
                $q->where('title', 'like', '%' . $params['search'] . '%')
                  ->orWhere('description', 'like', '%' . $params['search'] . '%');
            });
        }

        return $query->paginate($params['per_page']);
    }
}
