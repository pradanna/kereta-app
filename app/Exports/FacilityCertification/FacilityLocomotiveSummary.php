<?php

namespace App\Exports\FacilityCertification;

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

class FacilityLocomotiveSummary implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithDrawings
{
    /**
     * @var Collection $data
     */
    private $data;
    private $areas;

    public function __construct($data, $areas)
    {
        $this->data = $data;
        $this->areas = $areas;
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
    public function drawings()
    {
        // TODO: Implement drawings() method.
//        $drawing = new Drawing();
//        $drawing->setName('logo');
//        $drawing->setPath(public_path('images/local/logodjka.png'));
//        $drawing->setHeight(60); // Mengatur tinggi gambar
//        $drawing->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
//        $drawing->setOffsetX(0);
//
//        $drawing2 = new Drawing();
//        $drawing2->setName('logodjka');
//        $drawing2->setPath(public_path('images/local/logodishub.png'));
//        $drawing2->setHeight(60); // Mengatur tinggi gambar
//        $drawing2->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
//        $drawing2->setOffsetX(65);
//
//        $drawing3 = new Drawing();
//        $drawing3->setName('logodjkaw');
//        $drawing3->setPath(public_path('images/local/logo_btp.png'));
//        $drawing3->setHeight(60); // Mengatur tinggi gambar
//        $drawing3->setCoordinates('I3'); // Lokasi di sheet (misalnya A1)
//        $drawing3->setOffsetX(125);
//
//        return [$drawing, $drawing2, $drawing3];
        return [];
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        $rowLength = count($this->rowValues()) + 7;
        $cellRange = 'A7:E' . $rowLength;
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
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');
        $sheet->mergeCells('A4:E4');
        $sheet->mergeCells('A5:E5');
        $sheet->mergeCells('A6:E6');
        $sheet->getStyle('A1:E1')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:E2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:E3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:E4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:E5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:E6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:E6')->getFont()->setSize(16)->setBold(true);
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'REKAPITULASI SARANA';
    }

    private function headingValues()
    {
        $generatedHeadAreas = [];
        array_push($generatedHeadAreas, 'JENIS SARANA');
        foreach ($this->areas as $area) {
            array_push($generatedHeadAreas, $area->name);
        }
        array_push($generatedHeadAreas, 'TOTAL');
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
                'REKAP DATA SARANA LOKOMOTIF',
                '',
                '',
                '',
                '',
            ],
            [],
            $generatedHeadAreas,
        ];
    }

    private function rowValues()
    {
        $results = [];
        $facilityTypes = [
            'Lokomotif',
            'Kereta',
            'KRD',
            'KRL',
            'Gerbong',
            'Peralatan Khusus'
        ];
        foreach ($facilityTypes as $key => $facilityType) {
//            $no = $key + 1;
//            $areaName = $area->name;
//            $count = $this->data->where('area_id', '=', $area->id)->count();
//            $validItem = $this->data->where('area_id', '=', $area->id)
//                ->where('expired_in', '>', 0)
//                ->count();
//            $invalidItem = $this->data->where('area_id', '=', $area->id)
//                ->where('expired_in', '<=', 0)
//                ->count();
            $result = [
                $facilityType,
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
