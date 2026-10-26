<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    // Relasi ke Header Penjualan
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relasi ke Produk Sembako
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}