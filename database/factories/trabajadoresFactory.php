<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\empresas;


class TrabajadoresFactory extends Factory
{
    protected $model = \App\Models\trabajadores::class;
    
    public function definition(): array
    {
        return [
            'documento' => $this->generateDocumento(),
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastname,
            'cargo' => $this->faker->word,
            'estado' => $this->faker->boolean,
            'empresa_id' => empresas::inRandomOrder()->first()->id, 
        ];
    }
    private function generateDocumento()
    {
        // Decide aleatoriamente entre un documento de 8 o 12 caracteres
        $length = $this->faker->randomElement([8, 8]);
        return $this->faker->numerify(str_repeat('#', $length));
    }
}
