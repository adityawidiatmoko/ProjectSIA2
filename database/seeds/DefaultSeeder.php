<?php

use App\Akun;
use App\Barang;
use App\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //DatavDefault Barang
        Barang::create([
            'kd_brg' => '1',
            'nm_brg' => 'Buku',
            'harga' => '3000',
            'stok' => '10'
        ]);

        //Data Default Supplier
        Supplier::create([
            'kd_supp' => '1',
            'nm_supp' => 'Sinar Dunia',
            'alamat' => 'Bekasi',
            'telepon' => '089601568504'
        ]);

        //Data Default Akun
        Akun::create([
            'no_akun' => '101',
            'nm_akun' => 'KAS'
        ]);

        Akun::create([
            'no_akun' => '211',
            'nm_akun' => 'UTANG DAGANG'
        ]);

        Akun::create([
            'no_akun' => '500',
            'nm_akun' => 'PEMBELIAN'
        ]);

        // fix colom qty_beli di table detail_pembelian
        DB::unprepared('DROP TABLE detail_pembelian;');
        DB::unprepared('CREATE TABLE detail_pembelian(no_beli VARCHAR(20),kd_brg VARCHAR(5),qty_beli INT,sub_beli INT);');
    }
}
