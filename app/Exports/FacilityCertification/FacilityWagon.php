<?php

namespace App\Exports\FacilityCertification;

use App\Helper\Formula;
use Carbon\Carbon;
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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilityWagon implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithDrawings
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
        $rowLength = count($this->rowValues()) + 8;
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
        return $this->headingValues();
    }

    public function styles(Worksheet $sheet)
    {
        // TODO: Implement styles() method.
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        $sheet->mergeCells('A4:H4');
        $sheet->mergeCells('A5:H5');
        $sheet->mergeCells('A6:H6');
        $sheet->mergeCells('A7:K7');
        $sheet->mergeCells('I1:K6');

        $sheet->getStyle('A1:H1')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:H2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:H3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:H4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:H5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:H6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:K7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H7')->getFont()->setSize(16)->setBold(true);
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'GERBONG';
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
                '',
                '',
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
                '',
                '',
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
                '',
                '',
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
                '',
                '',
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
                '',
                '',
                '',
                '',
                '',
            ],
            [],
            [
                'NO.',
                'KEPEMILIKAN',
                'NO. SARANA',
                'WILAYAH',
                'DEPO INDUK',
                'MULAI DINAS',
                'MASA BERLAKU SARANA',
                'NOMOR BA PENGUJIAN',
                'AKAN HABIS (HARI)',
                'STATUS',
                'KETERANGAN',
            ]
        ];
    }

    private function rowValues()
    {
        $results = [];
        foreach ($this->data as $key => $datum) {
            $expirationText = '';
            if ($datum->expired_in <= 0) {
                $expirationText = 'HABIS MASA BERLAKU';
            }

            if ($datum->expired_in >= 1 && $datum->expired_in < 31) {
                $expirationText = 'AKAN HABIS MASA BERLAKU';
            }

            if ($datum->expired_in >= 31) {
                $expirationText = 'BERLAKU';
            }

            $no = $key + 1;
            $result = [
                $no,
                $datum->ownership,
                $datum->facility_number,
                $datum->area->name,
                $datum->storehouse->name . ' (' . $datum->storehouse->storehouse_type->name . ')',
                Carbon::parse($datum->service_start_date)->format('Y'),
                Carbon::parse($datum->service_expired_date)->format('d-m-Y'),
                $datum->testing_number,
                $datum->expired_in,
                $expirationText,
                $datum->description,
            ];
            array_push($results, $result);
        }
        return $results;
    }

    /**
     * @inheritDoc
     */
    public function drawings()
    {
        // TODO: Implement drawings() method.
        // TODO: Implement drawings() method.
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setPath(public_path('images/local/logodjka.png'));
        $drawing->setHeight(60); // Mengatur tinggi gambar
        $drawing->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
        $drawing->setOffsetX(0);

        $drawing2 = new Drawing();
        $drawing2->setName('logodjka');
        $drawing2->setPath(public_path('images/local/logodishub.png'));
        $drawing2->setHeight(60); // Mengatur tinggi gambar
        $drawing2->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
        $drawing2->setOffsetX(65);

        $drawing3 = new Drawing();
        $drawing3->setName('logodjkaw');
        $drawing3->setPath(public_path('images/local/logo_btp.png'));
        $drawing3->setHeight(60); // Mengatur tinggi gambar
        $drawing3->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
        $drawing3->setOffsetX(125);

        return [$drawing, $drawing2, $drawing3];
    }
}
