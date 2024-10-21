<?php

namespace App\Exports\FacilityCertification;

use App\Helper\Formula;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\BaseDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilitySpecialEquipment extends DefaultValueBinder implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithColumnFormatting, WithDrawings
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
        $rowLength = count($this->rowValues()) + 9;
        $cellRange = 'A8:J' . $rowLength;
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
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');
        $sheet->mergeCells('A3:G3');
        $sheet->mergeCells('A4:G4');
        $sheet->mergeCells('A5:G5');
        $sheet->mergeCells('A6:G6');
        $sheet->mergeCells('A7:J7');
        $sheet->mergeCells('H1:J6');
        $sheet->getStyle('A1:G1')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:G2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:G3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:G4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:G5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:G6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A7:J7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J7')->getFont()->setSize(16)->setBold(true);

        $sheet->mergeCells('A8:A9');
        $sheet->mergeCells('B8:B9');
        $sheet->mergeCells('C8:D8');
        $sheet->mergeCells('E8:E9');
        $sheet->mergeCells('F8:F9');
        $sheet->mergeCells('G8:G9');
        $sheet->mergeCells('H8:H9');
        $sheet->mergeCells('I8:I9');
        $sheet->mergeCells('J8:J9');

        $sheet->getStyle('A8:A9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B8:B9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C8:D8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('E8:E9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F8:F9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('G8:G9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H8:H9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('I8:I9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J8:J9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
                '',
                'WILAYAH',
                'MASA BERLAKU SARANA',
                'NOMOR BA PENGUJIAN',
                'AKAN HABIS (HARI)',
                'STATUS',
                'KETERANGAN',
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
                strval($datum->new_facility_number),
                strval($datum->old_facility_number),
                $datum->area->name,
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
    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
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
        $drawing->setCoordinates('H3'); // Lokasi di sheet (misalnya A1)
        $drawing->setOffsetX(0);

        $drawing2 = new Drawing();
        $drawing2->setName('logodjka');
        $drawing2->setPath(public_path('images/local/logodishub.png'));
        $drawing2->setHeight(60); // Mengatur tinggi gambar
        $drawing2->setCoordinates('H3'); // Lokasi di sheet (misalnya A1)
        $drawing2->setOffsetX(65);

        $drawing3 = new Drawing();
        $drawing3->setName('logodjkaw');
        $drawing3->setPath(public_path('images/local/logo_btp.png'));
        $drawing3->setHeight(60); // Mengatur tinggi gambar
        $drawing3->setCoordinates('H3'); // Lokasi di sheet (misalnya A1)
        $drawing3->setOffsetX(125);

        return [$drawing, $drawing2, $drawing3];
    }
}
