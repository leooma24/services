<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Automóvil',
            'type' => 1,
            'color' => '#1C7528',
            'icon' => 'directions_car'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Casa',
            'type' => 1,
            'color' => '#75571C',
            'icon' => 'house'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Comida',
            'type' => 1,
            'color' => '#9A8873',
            'icon' => 'food_bank'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Teléfono',
            'type' => 1,
            'color' => '#37423D',
            'icon' => 'phone'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Deportes',
            'type' => 1,
            'color' => '#2D9595',
            'icon' => 'sports'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Entretenimiento',
            'type' => 1,
            'color' => '#CC1830',
            'icon' => 'liquor'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Salud',
            'type' => 1,
            'color' => '#2D9595',
            'icon' => 'monitor_heart'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Regalos',
            'type' => 1,
            'color' => '#90F3BB',
            'icon' => 'card_giftcard'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Restaurante',
            'type' => 1,
            'color' => '#F5D327',
            'icon' => 'restaurant'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Ropa',
            'type' => 1,
            'color' => '#CF27F5',
            'icon' => 'checkroom'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Gymnasio',
            'type' => 1,
            'color' => '#CF27F5',
            'icon' => 'fitness_center'
        ]);

        DB::table('categories')->insert([
            'user_id' => 1,
            'title' => 'Sueldo',
            'type' => 0,
            'color' => '#CCC',
            'icon' => 'paid'
        ]);
    }
}
