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

class CrossingPermission implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        $cellRange = 'A1:N' . $rowLength;
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
        return 'PERMINTAAN IZIN MELINTAS REL';
    }

    private function headingValues()
    {
        return [
            'NO.',
            'WILAYAH',
            'LINTAS',
            'PETAK',
            'KM/HM',
            'NO. SK',
            'TANGGAL SK',
            'JENIS PERPOTONGAN/PERSINGGUNGAN',
            'JENIS BANGUNAN',
            'BADAN HUKUM/INSTANSI',
            'TANGGAL HABIS MASA BERLAKU',
            'AKAN HABIS',
            'STATUS',
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
                $datum->decree_number,
                $datum->decree_date,
                $datum->intersection,
                $datum->building_type,
                $datum->agency,
                $datum->expired_date,
                $datum->expired_in,
                ($datum->status === 'valid') ? 'BERLAKU' : 'HABIS MASA BERLAKU',
                $datum->description,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
