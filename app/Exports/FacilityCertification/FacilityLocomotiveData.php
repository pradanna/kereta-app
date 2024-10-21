<?php

namespace App\Exports\FacilityCertification;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FacilityLocomotiveData implements WithMultipleSheets
{

    use Exportable;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        // TODO: Implement sheets() method.
        return  [
            new FacilityLocomotiveSummary($this->data),
            new FacilityLocomotive($this->data),
        ];

    }
}
