<?php

namespace Database\Seeders;

use App\Models\FacilityType;
use Illuminate\Database\Seeder;

class FacilityTypeSeeder extends Seeder
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
                'name' => 'Lokomotif'
            ],
            [
                'name' => 'Kereta'
            ],
            [
                'name' => 'KRD'
            ],
            [
                'name' => 'KRL'
            ],
            [
                'name' => 'Gerbong'
            ],
            [
                'name' => 'Peralatan Khusus'
            ],
        ];
        foreach ($data as $datum) {
            FacilityType::create($datum);
        }
    }
}
