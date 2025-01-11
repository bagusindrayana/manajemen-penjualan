<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'stock',
        'purchase_price',
        'selling_price',
        'category',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
