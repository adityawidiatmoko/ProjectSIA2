<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LapStok extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE VIEW `lap_stok` AS (select `barang`.`kd_brg` AS `kd_brg`,`barang`.`nm_brg` 
        AS `nm_brg`,`barang`.`harga` AS `harga`,`barang`.`stok` AS 
        `stok`,sum(`detail_pembelian`.`qty_beli`) AS `beli`,sum(`detail_retur`.`qty_retur`) AS 
        `retur` from ((`barang` join `detail_retur`) join `detail_pembelian`) where 
        `barang`.`kd_brg` = `detail_retur`.`kd_brg` and `barang`.`kd_brg` = 
        `detail_pembelian`.`kd_brg` group by `barang`.`kd_brg`) ;    
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW lap_stok');
    }
}
