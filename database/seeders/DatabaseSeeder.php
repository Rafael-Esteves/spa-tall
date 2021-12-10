<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Marca;
use \App\Models\Produto;
use \App\Models\Fornecedor;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        Marca::factory()->times(20)->create();
        Produto::factory()->times(50)->create();
        Fornecedor::factory()->times(20)->create();

        $produtos = Produto::all();

        Fornecedor::all()->each(function ($fornecedor) use ($produtos) {
            $fornecedor->produtos()->attach($produtos->random(rand(1, 5)));
        });
    }
}
