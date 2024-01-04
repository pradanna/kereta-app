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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DirectPassageAccident implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        return  'PLH';
    }

    private function headingValues()
    {
        return [
            'NO.',
            'WILAYAH',
            'LINTAS',
            'PETAK',
            'KM/HM',
            'NO. JPL',
            'KOTA/KABUPATEN',
            'WAKTU KEJADIAN',
            'JENIS KERETA API',
            'JENIS LAKA',
            'LOKASI',
            'KORBAN LUKA-LUKA',
            'KORBAN MENINGGAL',
            'TOTAL KORBAN',
            'KERUGIAN',
            'KETERANGAN / TINDAK LANJUT',
            'KRONOLOGI',
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
                $datum->direct_passage !== null ? $datum->direct_passage->name : '-',
                $datum->city->name,
                $datum->date,
                $datum->train_name,
                $datum->accident_type,
                $datum->latitude . ', '.$datum->longitude,
                $datum->injured,
                $datum->died,
                ($datum->died + $datum->injured),
                $datum->damaged_description,
                $datum->description,
                $datum->chronology,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
