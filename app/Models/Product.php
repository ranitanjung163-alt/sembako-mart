<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Produk milik satu kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Produk memiliki banyak item dalam transaksi penjualan (SaleItem)
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}