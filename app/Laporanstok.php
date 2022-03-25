<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laporanstok extends Model
{
    protected $table = "lap_stok";
    protected $fillable = ['kd_brg','nm_brg','harga','stok','beli','retur'];
}
