<?php

namespace Database\Seeders;

use App\Models\ServiceUnit;
use Illuminate\Database\Seeder;

class ServiceUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'name' => 'Satpel Surakarta',
                'latitude' => -7.562105521391487,
                'longitude' => 110.83955170830154
            ],
            [
                'name' => 'Satpel Yogyakarta',
                'latitude' => -7.789021235590297,
                'longitude' => 110.36345216597756
            ],
            [
                'name' => 'Satpel Purwokerto',
                'latitude' => -7.419520573516469,
                'longitude' => 109.22187726597149
            ],
            [
                'name' => 'Satpel Pekalongan',
                'latitude' => -6.889498765813909,
                'longitude' => 109.66432145247164
            ],
        ];
        foreach ($data as $datum) {
            ServiceUnit::create($datum);
        }
    }
}
