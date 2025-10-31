<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'price', 'stock', 'img'];

    protected $casts = [
        'image_urls' => 'array',
    ];

    // สินค้า belongsTo หมวดหมู่
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_details')->withPivot('quantity', 'price')->withTimestamps();
    }
}
