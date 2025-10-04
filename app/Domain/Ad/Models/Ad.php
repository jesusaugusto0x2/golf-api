<?php

namespace App\Domain\Ad\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\User\Models\User;
use App\Domain\Category\Models\Category;

class Ad extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'price',
        'condition',
        'description',
        'ends_at',
        'ai_valuation',
        'estimated_market_price',
    ];

    protected $casts = [
        'ends_at' => 'datetime',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
