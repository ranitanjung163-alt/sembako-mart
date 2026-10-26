<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Transaksi milik satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Transaksi milik satu Supplier (opsional untuk pembelian)
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Relasi: Transaksi dilakukan oleh User / Pemesan (khususnya untuk penjualan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}