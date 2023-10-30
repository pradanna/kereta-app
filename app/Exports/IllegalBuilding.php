<?php

namespace App\Exports;

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

class IllegalBuilding implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        return new Collection($this->rowValues());
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        $rowLength = count($this->rowValues()) + 2;
        $cellRange = 'A1:K' . $rowLength;
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
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:E2');
        $sheet->mergeCells('F1:F2');
        $sheet->mergeCells('G1:H1');
        $sheet->mergeCells('I1:I2');
        $sheet->mergeCells('J1:J2');
        $sheet->mergeCells('K1:K2');
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'BANGUNAN LIAR';
    }

    private function headingValues()
    {
        return [
            [
                'NO.',
                'LINTAS',
                'ANTARA',
                'KM/HM',
                'KECAMATAN',
                'KABUPATEN',
                'LUAS',
                '',
                'JARAK DARI AS REL',
                'JUMLAH BANGUNAN LIAR',
                'SUDAH DI BONGKAR'
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                'TANAH (m2)',
                'BANGUNAN (m2)',
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
                $datum->sub_track->track->code,
                $datum->sub_track->code,
                $datum->stakes,
                $datum->district->name,
                $datum->district->city->name,
                $datum->surface_area,
                $datum->building_area,
                $datum->distance_from_rail,
                $datum->illegal_building,
                $datum->demolished,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
