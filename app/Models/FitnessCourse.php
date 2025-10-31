<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitnessCourse extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description', 'price', 'img'];

    protected $casts = [
        'image_urls' => 'array',
    ];
    // คอร์ส belongsTo หมวดหมู่
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
