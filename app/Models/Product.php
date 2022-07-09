<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table ="product_store";
    use HasFactory;
    protected $fillable = [
        'id',
        'store_id',
        'title',
        'description',
        'images'
    ];
}
