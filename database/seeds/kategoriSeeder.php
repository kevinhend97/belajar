<?php

use Illuminate\Database\Seeder;

class kategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori')->insert(array(
        	[
        		'nama_kategori' 		=> 'Baja',
        	],
        	[
        		'nama_kategori' 		=> 'Besi',
        	],
        	[
        		'nama_kategori' 		=> 'Kayu',
        	],
        	[
        		'nama_kategori' 		=> 'Pasir',
        	],
        	[
        		'nama_kategori' 		=> 'Semen',
        	],
        	[
        		'nama_kategori' 		=> 'Cat',
        	],
        	[
        		'nama_kategori' 		=> 'Pernis',
        	],
        	[
        		'nama_kategori' 		=> 'Tepentin',
        	],
        	[
        		'nama_kategori' 		=> 'Karbit',
        	],
        	[
        		'nama_kategori' 		=> 'Selang',
        	],
        ));
    }
}
