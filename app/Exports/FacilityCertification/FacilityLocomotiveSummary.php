<?php

namespace App\Exports\FacilityCertification;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilityLocomotiveSummary implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithDrawings
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
        return new Collection([]);
    }

    /**
     * @inheritDoc
     */
    public function drawings()
    {
        // TODO: Implement drawings() method.
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setPath(public_path('images/local/logodjka.png'));
        $drawing->setHeight(60); // Mengatur tinggi gambar
        $drawing->setCoordinates('J3'); // Lokasi di sheet (misalnya A1)
        $drawing->setOffsetX(0);

        $drawing2 = new Drawing();
        $drawing2->setName('logodjka');
        $drawing2->setPath(public_path('images/local/logodishub.png'));
        $drawing2->setHeight(60); // Mengatur tinggi gambar
        $drawing2->setCoordinates('J3'); // Lokasi di sheet (misalnya A1)
        $drawing2->setOffsetX(65);

        $drawing3 = new Drawing();
        $drawing3->setName('logodjkaw');
        $drawing3->setPath(public_path('images/local/logo_btp.png'));
        $drawing3->setHeight(60); // Mengatur tinggi gambar
        $drawing3->setCoordinates('J3'); // Lokasi di sheet (misalnya A1)
        $drawing3->setOffsetX(125);

        return [$drawing, $drawing2, $drawing3];
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
//        $rowLength = count($this->rowValues()) + 8;
        $rowLength = 8;
        $cellRange = 'A8:K' . $rowLength;
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
        return  $this->headingValues();
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
        return 'REKAPITULASI LOKOMOTIF';
    }

    private function headingValues()
    {
        return [
            [
                'KEMENTERIAN PERHUBUNGAN',
                '',
                '',
                '',
                '',
            ],
            [
                'DIREKTORAT JENDERAL PERKERETAAPIAN',
                '',
                '',
                '',
                '',
            ],
            [
                'BALAI TEKNIK PERKERETAAPIAN KELAS I SEMARANG',
                '',
                '',
                '',
                '',
            ],
            [],
            [
                'DATA SERTIFIKASI KELAIKAN SARANA PERKERETAAPIAN',
                '',
                '',
                '',
                '',
            ],
            [
                'DEPO SARANA PENGGERAK & TANPA PENGGERAK ',
                '',
                '',
                '',
                '',
                '',
            ],
            [],
            [
                'NO.',
                'WILAYAH',
                'JUMLAH',
                'BERLAKU',
                'KADALUARSA',
            ],
        ];
    }
}
