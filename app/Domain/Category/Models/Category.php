<?php
namespace App\Domain\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Ad\Models\Ad;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
}
