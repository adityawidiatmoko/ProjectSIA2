<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ViewTempPesan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE VIEW `view_temp_pesan` AS SELECT `temp_pemesanan`.`kd_brg` AS 
        `kd_brg`, concat(`barang`.`nm_brg`,`barang`.`harga`) 
        AS `nm_brg`,`temp_pemesanan`.`qty_pesan` AS `qty_pesan`, `barang`.`harga`* 
        `temp_pemesanan`.`qty_pesan` AS `sub_total` FROM (`temp_pemesanan` join 
        `barang`) WHERE `temp_pemesanan`.`kd_brg` = `barang`.`kd_brg` ;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_temp_pesan;');
    }
}
