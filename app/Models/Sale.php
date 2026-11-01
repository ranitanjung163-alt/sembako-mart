<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_number',
        'customer_name', // Ditambahkan agar aman jika form kasir mengirim nama pembeli
        'total_amount',
        'paid_amount',
        'change_amount',
    ];

    // Relasi ke User (Kasir / Staff yang bertugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Detail Item Penjualan
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    // Alias relasi tambahan (opsional untuk jaga-jaga jika ada controller lain yang memanggil saleItems)
    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}