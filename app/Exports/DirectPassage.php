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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DirectPassage implements FromCollection, WithHeadings, WithStyles, WithStrictNullComparison, WithTitle, ShouldAutoSize, WithEvents
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
        $rowLength = count($this->rowValues()) + 4;
        $cellRange = 'A1:AE' . $rowLength;
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
        $sheet->mergeCells('A1:A4');
        $sheet->mergeCells('B1:B4');
        $sheet->mergeCells('C1:C4');
        $sheet->mergeCells('D1:D4');
        $sheet->mergeCells('E1:F1');
        $sheet->mergeCells('E2:E4');
        $sheet->mergeCells('F2:F4');
        $sheet->mergeCells('G1:G4');
        $sheet->mergeCells('H1:H4');
        $sheet->mergeCells('I1:I4');
        $sheet->mergeCells('J1:J4');
        $sheet->mergeCells('K1:K4');
        $sheet->mergeCells('L1:L4');
        $sheet->mergeCells('M1:M4');
        $sheet->mergeCells('N1:N4');
        $sheet->mergeCells('N1:N4');
        $sheet->mergeCells('O1:S1');
        $sheet->mergeCells('O2:Q2');
        $sheet->mergeCells('O3:P3');
        $sheet->mergeCells('O3:P3');
        $sheet->mergeCells('R2:R4');
        $sheet->mergeCells('S2:S4');
        $sheet->mergeCells('T1:T4');
        $sheet->mergeCells('U1:AE1');
        $sheet->mergeCells('U2:U4');
        $sheet->mergeCells('V2:V4');
        $sheet->mergeCells('W2:W4');
        $sheet->mergeCells('X2:X4');
        $sheet->mergeCells('Y2:Y4');
        $sheet->mergeCells('Z2:Z4');
        $sheet->mergeCells('AA2:AA4');
        $sheet->mergeCells('AB2:AB4');
        $sheet->mergeCells('AC2:AC4');
        $sheet->mergeCells('AD2:AD4');
        $sheet->mergeCells('AE2:AE4');
        $sheet->getStyle('O1:S1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        // TODO: Implement title() method.
        return 'JPL';
    }

    private function headingValues()
    {
        return [
            [
                'NO.',
                'WILAYAH',
                'LINTAS',
                'ANTARA',
                'PM 94 / 2018',
                '',
                'KOORDINAT LOKASI',
                'USULAN PENATAAN PERLINTASAN',
                'RIWAYAT KECELAKAAN',
                'KELAS JALAN',
                'LEBAR JALAN (m)',
                'KONSTRUKSI JALAN',
                'NAMA JALAN / DAERAH',
                'KOTA / KABUPATEN',
                'STATUS',
                '',
                '',
                '',
                '',
                'KETERANGAN',
                'PERLENGKAPAN RAMBU',
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
                '',
                '',
                '',
                '',
                'JPL',
                'KM / HM',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'RESMI DIJAGA',
                '',
                '',
                'RESMI TIDAK DIJAGA',
                'LIAR',
                '',
                'PERINGATAN MEMBUNYIKAN LOKOMOTIF',
                'PERINGATAN PINTU PERLINTASAN SEBIDANG',
                'PERINGATAN TANPA PINTU PERLINTASAN SEBIDANG',
                'PERINGATAN',
                'JARAK LOKASI KRITIS 450M',
                'JARAK LOKASI KRITIS 300M',
                'JARAK LOKASI KRITIS 100M',
                'RAMBU STOP',
                'LARANGAN BERJALAN',
                'LARANGAN MASUK KENDARAAN',
                'GARIS KEJUT',
            ],
            [
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
                '',
                '',
                '',
                '',
                'PT. KAI',
                '',
                'PEMDA',
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
                '',
                '',
                '',
                '',
            ],
            [
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
                '',
                '',
                '',
                '',
                'OP',
                'JJ',
                'INSTANSI LAIN',
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
                '',
                '',
                '',
                '',
            ]

        ];
    }

    private function rowValues()
    {
        $results = [];
        foreach ($this->data as $key => $datum) {
            $no = $key + 1;
            $result = [
                $no,
                $datum->sub_track->track->area->name,
                $datum->sub_track->track->code,
                $datum->sub_track->code,
                $datum->name,
                $datum->stakes,
                $datum->latitude . ', '.$datum->longitude,
                $datum->arrangement_proposal === 0 ? '-' : 'v',
                $datum->accident_history,
                '-',
                $datum->width,
                $datum->road_construction,
                $datum->road_name,
                $datum->city->name,
                ($datum->guarded_by === 0 ? 'v' : '-'),
                ($datum->guarded_by === 1 ? 'v' : '-'),
                ($datum->guarded_by === 2 ? 'v' : '-'),
                ($datum->guarded_by === 3 ? 'v' : '-'),
                ($datum->guarded_by === 4 ? 'v' : '-'),
                $datum->description,
                ($datum->sign_equipment->locomotive_flute === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->crossing_gate === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->non_crossing_gate === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->warning === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->critical_distance_450 === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->critical_distance_300 === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->critical_distance_100 === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->stop_sign === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->walking_ban === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->vehicle_entry_ban === 1 ? 'ada' : '-'),
                ($datum->sign_equipment->shock_line === 1 ? 'ada' : '-'),
            ];
            array_push($results, $result);
        }
        return $results;
    }
}
