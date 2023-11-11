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
                'name' => 'Depo Lokomotif',
                'marker_icon' => '/images/marker/locomotive.png'
            ],
            [
                'name' => 'Depo Kereta',
                'marker_icon' => '/images/marker/train.png'
            ],
            [
                'name' => 'Pengawas Urusan Kereta',
                'marker_icon' => '/images/marker/train-supervisor.png'
            ],
            [
                'name' => 'Depo Gerbong',
                'marker_icon' => '/images/marker/wagon.png'
            ],
            [
                'name' => 'Balai Yasa Gerbong',
                'marker_icon' => '/images/marker/wagon-office.png'
            ],
            [
                'name' => 'Depo KRL',
                'marker_icon' => '/images/marker/electric-train.png'
            ],
            [
                'name' => 'Pengawas Urusan Sarana',
                'marker_icon' => '/images/marker/facility-supervisor.png'
            ],
            [
                'name' => 'Balai Yasa KRL',
                'marker_icon' => '/images/marker/facility-supervisor.png'
            ],
        ];
        foreach ($data as $datum) {
            StorehouseType::create($datum);
        }
    }
}
