<?php

use Illuminate\Database\Seeder;

class satuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('satuan')->insert(array(
        	[
        		'nama_satuan' 		=> 'Kilogram',
        	],
        	[
        		'nama_satuan' 		=> 'Kaleng',
        	],
        	[
        		'nama_satuan' 		=> 'Liter',
        	],
        	[
        		'nama_satuan' 		=> 'Ons',
        	],
        	[
        		'nama_satuan' 		=> 'Pcs',
        	],
        	[
        		'nama_satuan' 		=> 'Lusin',
        	],
        ));
    }
}
