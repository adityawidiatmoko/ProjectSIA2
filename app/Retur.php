<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $primaryKey = 'no_retur';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $table = "retur_beli";
    protected $fillable=['no_retur','tgl_retur','total_retur'];
}
