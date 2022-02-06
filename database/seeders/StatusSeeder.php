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
                'code' => 0001,
                'description' => 'Reservado',
            ],
            [
                'code' => 0002,
                'description' => 'Pago',
            ],
            [
                'code' => 0003,
                'description' => 'Reclamado',
            ],
            [
                'code' => 0004,
                'description' => 'Cancelado',
            ]
        ]);
    }
}
