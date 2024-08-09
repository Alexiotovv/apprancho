<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TrabajadoresSeeder::class);

        DB::table('users')->insert([
            'name'=>'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('#1984'),
            'role' => 'admin',
            'status'=>1,
        ]);

        // DB::table('empresas')->insert([
        //     [
        //         'nombre' => 'EVITA PRUEBA',
        //         'estado' => 1,
        //     ],
        //     [
        //         'nombre' => 'MANU EIRL',
        //         'estado' => 1,
        //     ]
        // ]);
        
        DB::table('proveedores')->insert([
            [
                'nombre' => 'AYWSOLUTION SAC'
            ],
            [
                'nombre' => 'PRIMOSAC'
            ]
        ]);
        
        // DB::statement("
        //     CREATE PROCEDURE sp_scc_pagos()
        //     BEGIN
        //         SELECT 
        //             YEAR(pagos.fecha) AS anho,
        //             MONTH(pagos.fecha) AS mes_numero,
        //             MONTHNAME(pagos.fecha) AS mes_nombre,
        //             SUM(pagos.monto) AS total_pagos
        //         FROM pagos
        //         WHERE pagos.fecha >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        //         GROUP BY YEAR(pagos.fecha), MONTHNAME(pagos.fecha), MONTH(pagos.fecha)
        //         ORDER BY YEAR(pagos.fecha), MONTH(pagos.fecha) DESC;
        //     END
        // ");
    }
}
