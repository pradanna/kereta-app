<?php

namespace App\Exports\FacilityCertification;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FacilityLocomotiveData implements WithMultipleSheets
{

    use Exportable;
    private $data;
    private $areas;
    private $facilitiesData;

    public function __construct($data, $areas, $facilitiesData)
    {
        $this->data = $data;
        $this->areas = $areas;
        $this->facilitiesData = $facilitiesData;
    }
    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        // TODO: Implement sheets() method.
        return  [
            new FacilityLocomotiveSummary($this->data, $this->areas, $this->facilitiesData),
            new FacilityLocomotive($this->data),
        ];

    }
}
