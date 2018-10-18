<?php

use Illuminate\Database\Seeder;

class kotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kota')->insert(array(
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Cilacap',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Purwokerto',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Tegal',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Pemalang',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Pekalongan',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Banjarnegara',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Wonosobo',
        	],
        	[
        		'provinsi_id' 		=> '1',
        		'nama_kota' 		=> 'Semarang',
        	],
        ));
    }
}
