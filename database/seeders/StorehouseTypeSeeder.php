<?php

namespace Database\Seeders;

use App\Models\StorehouseType;
use Illuminate\Database\Seeder;

class StorehouseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Depo Lokomotif'
            ],
            [
                'name' => 'Depo Kereta'
            ],
            [
                'name' => 'Pengawas Urusan Kereta'
            ],
            [
                'name' => 'Depo Gerbong'
            ],
            [
                'name' => 'Balai Yasa Gerbong'
            ],
            [
                'name' => 'Depo KRL'
            ],
            [
                'name' => 'Pengawas Urusan Sarana'
            ],
        ];
        foreach ($data as $datum) {
            StorehouseType::create($datum);
        }
    }
}
