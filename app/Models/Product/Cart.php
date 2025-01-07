<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'image',
        'user_id',
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
