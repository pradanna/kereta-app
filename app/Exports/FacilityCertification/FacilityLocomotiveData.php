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

    public function __construct($data, $areas)
    {
        $this->data = $data;
        $this->areas = $areas;
    }
    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        // TODO: Implement sheets() method.
        return  [
            new FacilityLocomotiveSummary($this->data, $this->areas),
            new FacilityLocomotive($this->data),
        ];

    }
}
