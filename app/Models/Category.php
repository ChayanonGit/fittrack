<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description', 'img'];

    // หมวดหมู่มีหลายสินค้า
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // หมวดหมู่มีหลายคอร์สฟิตเนส
    public function fitnessCourses()
    {
        return $this->hasMany(FitnessCourse::class);
    }
}
