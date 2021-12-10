<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cnpj' => $this->faker->cnpj,
            'nome' => $this->faker->name,
            'nome_fantasia' => $this->faker->name,
            'cpf' => $this->faker->cpf,
        ];
    }
}
