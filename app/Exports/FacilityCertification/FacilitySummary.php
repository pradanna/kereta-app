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
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilitySummary implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents, WithDrawings
{
    private $areas;
    private $facilitiesData;

    public function __construct($areas, $facilitiesData)
    {
        $this->areas = $areas;
        $this->facilitiesData = $facilitiesData;
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
        $drawing = new Drawing();
        $drawing->setName('logo');
        $drawing->setPath(public_path('images/local/logodjka.png'));
        $drawing->setHeight(50); // Mengatur tinggi gambar
        $drawing->setCoordinates('I2'); // Lokasi di sheet (misalnya A1)
        $drawing->setOffsetX(0);

        $drawing2 = new Drawing();
        $drawing2->setName('logodjka');
        $drawing2->setPath(public_path('images/local/logodishub.png'));
        $drawing2->setHeight(50); // Mengatur tinggi gambar
        $drawing2->setCoordinates('I2'); // Lokasi di sheet (misalnya A1)
        $drawing2->setOffsetX(60);

        $drawing3 = new Drawing();
        $drawing3->setName('logodjkaw');
        $drawing3->setPath(public_path('images/local/logo_btp.png'));
        $drawing3->setHeight(50); // Mengatur tinggi gambar
        $drawing3->setCoordinates('J2'); // Lokasi di sheet (misalnya A1)
        $drawing3->setOffsetX(50);

        return [$drawing, $drawing2, $drawing3];
    }

    /**
     * @inheritDoc
     */
    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        $dynamicColumnStart = 3;
        $numberOfColumns = count($this->areas);
        $dynamicColumnEnd = $dynamicColumnStart + $numberOfColumns - 1;
        $lastColumn = $dynamicColumnStart + $numberOfColumns;
        $lastColumnLetter = Coordinate::stringFromColumnIndex($lastColumn);
        $rowLength = count($this->rowValues()) + 7;
        $cellRange = 'A7:' . $lastColumnLetter . $rowLength;
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
        $dynamicColumnStart = 3;
        $numberOfColumns = count($this->areas);
        $dynamicColumnEnd = $dynamicColumnStart + $numberOfColumns - 1;
        $lastColumn = $dynamicColumnStart + $numberOfColumns;
        $lastColumnLetter = Coordinate::stringFromColumnIndex($lastColumn);
//        $sheet->getColumnDimension('A')->setAutoSize(false);
//        $sheet->getColumnDimension('A')->setWidth(75);

        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');
        $sheet->mergeCells('A4:H4');
        $sheet->mergeCells('A5:H5');
        $sheet->mergeCells('I1:L5');
        $sheet->mergeCells('A14:B14');
        $sheet->mergeCells('A6:' . $lastColumnLetter . '6');
        $sheet->getStyle('A1:H1')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle('A2:H2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:H3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:H4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:H5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A14:B14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:' . $lastColumnLetter . '6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:H6')->getFont()->setSize(12)->setBold(true);
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
        $generatedTitleLine1 = [];
        $generatedTitleLine2 = [];
        $generatedTitleLine3 = [];
        $generatedTitleLine4 = [];
        array_push($generatedHeadAreas, 'NO.');
        array_push($generatedHeadAreas, 'JENIS SARANA');
        array_push($generatedTitleLine1, 'KEMENTERIAN PERHUBUNGAN');
        array_push($generatedTitleLine2, 'DIREKTORAT JENDERAL PERKERETAAPIAN');
        array_push($generatedTitleLine3, 'BALAI TEKNIK PERKERETAAPIAN KELAS I SEMARANG');
        array_push($generatedTitleLine4, 'REKAPITULASI DATA SARANA');
        for ($i = 0; $i < 11; $i++) {
            array_push($generatedTitleLine1, '');
            array_push($generatedTitleLine2, '');
            array_push($generatedTitleLine3, '');
            array_push($generatedTitleLine4, '');
        }
        foreach ($this->areas as $area) {
            array_push($generatedHeadAreas, $area->name);

        }
        array_push($generatedHeadAreas, 'TOTAL');

        return [
            $generatedTitleLine1,
            $generatedTitleLine2,
            $generatedTitleLine3,
            [],
            $generatedTitleLine4,
            [],
            $generatedHeadAreas,
        ];
    }

    private function rowValues()
    {
        $results = [];
        $facilityTypes = [
            [
                'key' => 'locomotives',
                'title' => 'Lokomotif'
            ],
            [
                'key' => 'trains',
                'title' => 'Kereta'
            ],
            [
                'key' => 'diesel_trains',
                'title' => 'KRD'
            ],
            [
                'key' => 'electric_trains',
                'title' => 'KRL'
            ],
            [
                'key' => 'wagons',
                'title' => 'Gerbong'
            ],
            [
                'key' => 'special_equipments',
                'title' => 'Peralatan Khusus'
            ]
        ];

        $arrTotal = [];
        array_push($arrTotal, 'TOTAL');
        array_push($arrTotal, '');
        $matrix = [];

        foreach ($facilityTypes as $key => $facilityType) {
            $result = [];
            $matrixLine = [];
            array_push($result, ($key + 1));
            array_push($result, $facilityType['title']);
            $facilityKey = $facilityType['key'];
            /** @var Collection $facilities */
            $facilities = $this->facilitiesData[$facilityKey];
            $total = 0;
            foreach ($this->areas as $area) {
                $count = $facilities->where('area_id', '=', $area->id)->count();
                $total += $count;
                array_push($result, $count);
                array_push($matrixLine, $count);
            }
            array_push($result, $total);
            array_push($matrixLine, $total);
            array_push($results, $result);
            array_push($matrix, $matrixLine);
        }

        $columnSums = array_fill(0, count($matrix[0]), 0);
        foreach ($matrix as $row) {
            foreach ($row as $colIndex => $value) {
                $columnSums[$colIndex] += $value;
            }
        }

        $summaryLine = array_merge($arrTotal, $columnSums);
        array_push($results, $summaryLine);
        return $results;
    }
}
