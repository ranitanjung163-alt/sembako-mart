<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = ['id'];

    // Relasi: Supplier melayani banyak transaksi pembelian
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}