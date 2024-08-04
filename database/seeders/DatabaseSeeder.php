<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Entity;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        //User::truncate();
        Product::truncate();
        Entity::truncate();
        // DB::table('entity_tag')->truncate();

        //User::flushEventListeners();
        Product::flushEventListeners();
        Entity::flushEventListeners();

        
        $cantidadEntidades = 6;
        $cantidadProductos = 30;

        \App\Models\Entity::factory($cantidadEntidades)->create();
        \App\Models\Product::factory($cantidadProductos)->create();
    
        

		// factory(Entity::class, $cantidadTags)->create()->each(
		// 	function ($entity) {
		// 		$tag = Tags::all()->random(mt_rand(1, 5))->pluck('id');
		// 		$entity->tags()->attach($tag);

		// 	}
		// );        
        


    }
}
