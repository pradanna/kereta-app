<?php

namespace App\Exports;

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

class DisasterArea implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        $cellRange = 'A1:J' . $rowLength;
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
        return 'DAERAH RAWAN BENCANA';
    }

    private function headingValues()
    {
        return [
            'NO.',
            'RESORT',
            'TIPE LOKASI',
            'KM',
            'PETAK',
            'KOORDINAT',
            'JALUR',
            'JENIS RAWAN',
            'PENANGANAN',
            'KETERANGAN'
        ];
    }

    private function rowValues()
    {
        $results = [];
        foreach ($this->data as $key => $datum) {
            $no = $key + 1;
            $locationTypeValue = '-';
            switch ($datum->location_type) {
                case 0:
                    $locationTypeValue = 'Jalan Rel';
                    break;
                case 1:
                    $locationTypeValue = 'Jembatan';
                    break;
                default:
                    break;
            }

            $result = [
                $no,
                $datum->resort->name,
                $locationTypeValue,
                $datum->block,
                $datum->sub_track->code,
                strval($datum->latitude) .','. strval($datum->longitude),
                $datum->lane,
                $datum->disaster_type->name,
                $datum->handling,
                $datum->description,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
