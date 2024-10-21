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

class FacilityTrain implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithDrawings
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
        $cellRange = 'A8:M' . $rowLength;
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
        $sheet->mergeCells('A1:J1');
        $sheet->mergeCells('A2:J2');
        $sheet->mergeCells('A3:J3');
        $sheet->mergeCells('A4:J4');
        $sheet->mergeCells('A5:J5');
        $sheet->mergeCells('A6:J6');
        $sheet->mergeCells('A7:M7');
        $sheet->mergeCells('K1:M6');
        $sheet->getStyle('A1:J1')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A1:J1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:J2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:J3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:J4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:J5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:J6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K1:M6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:M7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:M7')->getFont()->setSize(16)->setBold(true);
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
                'JENIS KERETA',
                'TIPE KERETA',
                'DEPO INDUK',
                'MULAI DINAS',
                'MASA BERLAKU SARANA',
                'NOMOR BA PENGUJIAN',
                'AKAN HABIS (HARI)',
                'STATUS',
                'KETERANGAN'
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
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setPath(public_path('images/local/logodjka.png'));
        $drawing->setHeight(60); // Mengatur tinggi gambar
        $drawing->setCoordinates('L3'); // Lokasi di sheet (misalnya A1)
        $drawing->setOffsetX(0);

        $drawing2 = new Drawing();
        $drawing2->setName('logodjka');
        $drawing2->setPath(public_path('images/local/logodishub.png'));
        $drawing2->setHeight(60); // Mengatur tinggi gambar
        $drawing2->setCoordinates('L3'); // Lokasi di sheet (misalnya A1)
        $drawing2->setOffsetX(65);

        $drawing3 = new Drawing();
        $drawing3->setName('logodjkaw');
        $drawing3->setPath(public_path('images/local/logo_btp.png'));
        $drawing3->setHeight(60); // Mengatur tinggi gambar
        $drawing3->setCoordinates('L3'); // Lokasi di sheet (misalnya A1)
        $drawing3->setOffsetX(125);

        return [$drawing, $drawing2, $drawing3];
    }
}
