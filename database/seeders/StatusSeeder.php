<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'id' => 1,
                'code' => 10,
                'description' => 'Reservado',
            ],
            [
                'id' => 2,
                'code' => 20,
                'description' => 'Pago',
            ],
            [
                'id' => 3,
                'code' => 30,
                'description' => 'Reclamado',
            ],
            [
                'id' => 4,
                'code' => 40,
                'description' => 'Cancelado',
            ]
        ]);
    }
}
