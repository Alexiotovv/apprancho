<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\trabajadores;
use App\Models\empresas;

class TrabajadoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        empresas::factory()->count(2)->create();
        trabajadores::factory()->count(100)->create();

    }
}
