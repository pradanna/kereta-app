<?php

namespace App\Exports\FacilityCertification;

use App\Helper\Formula;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilityTrain implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        return new Collection($this->rowValues());
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        $rowLength = count($this->rowValues()) + 1;
        $cellRange = 'A1:M' . $rowLength;
        return [
            AfterSheet::class => function (AfterSheet $event) use ($cellRange) {
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000']
                        ],
                    ],
                ]);
            }
        ];
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return $this->headingValues();
    }

    public function styles(Worksheet $sheet)
    {
        // TODO: Implement styles() method.
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'KERETA';
    }

    private function headingValues()
    {
        return [
            'NO.',
            'KEPEMILIKAN',
            'NO. SARANA',
            'WILAYAH',
            'JENIS KERETA',
            'TIPE KERETA',
            'DEPO INDUK',
            'MULAI DINAS',
            'MASA BERLAKU SARANA',
            'NOMOR BA PENGUJIAN',
            'AKAN HABIS (HARI)',
            'STATUS',
            'KETERANGAN'
        ];
    }

    private function rowValues()
    {
        $results = [];
        foreach ($this->data as $key => $datum) {
            $no = $key + 1;
            $engineType = '-';
            switch ($datum->engine_type) {
                case 'train':
                    $engineType = 'Kereta Non Penggerak';
                    break;
                case 'electric-train':
                    $engineType = 'KRL';
                    break;
                case 'diesel-train':
                    $engineType = 'KRD';
                    break;
                default:
                    break;
            }
            $result = [
                $no,
                $datum->ownership,
                $datum->facility_number,
                $datum->area->name,
                $datum->train_type_string,
                $engineType,
                $datum->storehouse->name . ' (' . $datum->storehouse->storehouse_type->name . ')',
                Carbon::parse($datum->service_start_date)->format('d-m-Y'),
                Carbon::parse($datum->service_expired_date)->format('d-m-Y'),
                $datum->testing_number,
                $datum->expired_in,
                ($datum->expired_in <= Formula::ExpirationLimit ? 'HABIS MASA BERLAKU' : 'BERLAKU'),
                $datum->description,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
