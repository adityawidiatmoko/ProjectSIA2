<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPesan extends Model
{
   
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = "detail_pesan";
    protected $fillable=['no_pesan','kd_brg','qty_pesan','subtotal'];
}
