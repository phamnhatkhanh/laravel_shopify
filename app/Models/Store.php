<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'app_token',
        'app_status',
        'email',
        'domain',
        'myshopify_domain',
        'name_merchant',
        'plan',
    ];
}
