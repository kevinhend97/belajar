<?php

use Illuminate\Database\Seeder;

class provinsiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinsi')->insert(array(
        	[
        		'nama_provinsi' 		=> 'Jawa Tengah',
        	],
        	[
        		'nama_provinsi' 		=> 'Jawa Barat',
        	],
        	[
        		'nama_provinsi' 		=> 'Jawa Timur',
        	],
        	[
        		'nama_provinsi' 		=> 'Daerah Istimewa Yogyakarta',
        	],
        	[
        		'nama_provinsi' 		=> 'Jakarta',
        	],
        	[
        		'nama_provinsi' 		=> 'Sumatera Barat',
        	],
        	[
        		'nama_provinsi' 		=> 'Sumatera Utara',
        	],
        	[
        		'nama_provinsi' 		=> 'Nanggroe Aceh Darrusalam',
        	],
        	[
        		'nama_provinsi' 		=> 'Bangka Belitung',
        	],
        	[
        		'nama_provinsi' 		=> 'Papua',
        	],
        ));
    }
}
