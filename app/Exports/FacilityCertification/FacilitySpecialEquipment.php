<?php

namespace App\Exports\FacilityCertification;

use App\Helper\Formula;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilitySpecialEquipment extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithColumnFormatting
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
        $rowLength = count($this->rowValues()) + 2;
        $cellRange = 'A1:I' . $rowLength;
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
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:D1');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:G2');
        $sheet->mergeCells('H1:H2');
        $sheet->mergeCells('I1:I2');

    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'PERALATAN KHUSUS';
    }

    private function headingValues()
    {
        return [
            [
                'NO.',
                'KEPEMILIKAN',
                'NO. SARANA',
                '',
                'WILAYAH',
                'MASA BERLAKU SARANA',
                'NOMOR BA PENGUJIAN',
                'AKAN HABIS (HARI)',
                'STATUS'
            ],
            [
                '',
                '',
                'BARU',
                'LAMA',
                '',
                '',
                '',
                '',
                ''
            ]

        ];
    }

    private function rowValues()
    {
        $results = [];
        foreach ($this->data as $key => $datum) {
            $no = $key + 1;
            $result = [
                $no,
                $datum->ownership,
                strval($datum->new_facility_number),
                strval($datum->old_facility_number),
                $datum->area->name,
                Carbon::parse($datum->service_expired_date)->format('d-m-Y'),
                $datum->testing_number,
                $datum->expired_in,
                ($datum->expired_in <= Formula::ExpirationLimit ? 'HABIS MASA BERLAKU' : 'BERLAKU'),
            ];
            array_push($results, $result);
        }
        return $results;
    }

    /**
     * @inheritDoc
     */
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }
}
