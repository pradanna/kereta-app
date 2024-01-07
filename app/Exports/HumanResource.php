<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HumanResource implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
{
    private $data;
    private $type;

    public function __construct($data, $type)
    {
        $this->data = $data;
        $this->type = $type;
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
        $rowLength = count($this->rowValues()) + 3;
        $cellRange = 'A3:L' . $rowLength;
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
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1:L1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'SDM-' . $this->type;
    }

    private function headingValues()
    {
        return [
            ['Rekap Sumber Daya Manusia ' . $this->type],
            [],
            [
                'NO.',
                'WILAYAH',
                'NAMA',
                'TEMPAT LAHIR',
                'TANGGAL LAHIR',
                'NO. IDENTITAS',
                'UNIT PENGAJUAN SERTIFIKASI',
                'KODEFIKASI SERTIFIKAT',
                'TANGGAL HABIS BERLAKU',
                'AKAB HABIS',
                'STATUS',
                'KETERANGAN'
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
                $datum->area->name,
                $datum->name,
                $datum->birth_place,
                $datum->date_of_birth,
                strval($datum->identity_number),
                $datum->certification_unit,
                strval($datum->certification_number),
                $datum->expired_date,
                $datum->description,
                $datum->expired_in,
                ($datum->status === 'valid' ? 'BERLAKU' : 'HABIS MASA BERLAKU'),
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
