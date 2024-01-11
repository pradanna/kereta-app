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

class TrainBridge implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        $cellRange = 'A1:Q' . $rowLength;
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
        return 'JEMBATAN KERETA API';
    }

    private function headingValues()
    {
        return [
            'NO.',
            'WILAYAH',
            'LINTAS',
            'PETAK',
            'KM/HM',
            'KORIDOR',
            'NO. BH',
            'JEMBATAN',
            'JENIS BANGUNAN',
            'BENANG',
            'DI PASANG',
            'DI GANTI',
            'DI PERKUAT',
            'VOLUME ANDAS (BUAH)',
            'JUMLAH BANTALAN (BUAH)',
            'JUMLAH BAUT (BUAH)',
            'KETERANGAN',
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
                $datum->track->code,
                $datum->sub_track->code,
                $datum->stakes,
                $datum->corridor,
                $datum->reference_number,
                $datum->bridge_type,
                $datum->building_type,
                $datum->span,
                Carbon::parse($datum->installed_date)->format('Y'),
                Carbon::parse($datum->replaced_date)->format('Y'),
                Carbon::parse($datum->strengthened_date)->format('Y'),
                $datum->volume,
                $datum->bolt,
                $datum->bearing,
                $datum->description,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
