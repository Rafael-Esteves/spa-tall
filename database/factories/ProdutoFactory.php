<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Marca;



class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'preco' => $this->faker->randomFloat(2, 0, 100),
            'quantidade' => $this->faker->randomDigit,
            'marca_id' => Marca::all()->random()->id,
        ];
    }
}
