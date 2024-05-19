<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportLabaRugi implements FromArray, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        // Apply borders to the entire table
        $sheet->getStyle('A5:E' . (count($this->data)))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $sheet->mergeCells('A1:E1');
        $sheet->mergeCells('A2:E2');
        $sheet->mergeCells('A3:E3');

        $sheet->mergeCells('A5:E5');
        $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B6:E6');
        $sheet->mergeCells('B12:D12');
        $sheet->mergeCells('B13:E13');

        $sheet->mergeCells('B23:D23');
        $sheet->mergeCells('B24:E24');
        $sheet->mergeCells('B25:E25');
        $sheet->mergeCells('B26:E26');

        $sheet->mergeCells('B36:E36');
        $sheet->mergeCells('B37:E37');
        $sheet->mergeCells('B47:D47');
        $sheet->mergeCells('B48:E48');
        $sheet->mergeCells('B49:E49');
        $sheet->mergeCells('B50:E50');
        $sheet->mergeCells('B52:D52');
        $sheet->mergeCells('B53:E53');
        $sheet->mergeCells('B63:D63');

        $sheet->mergeCells('B64:D64');
        $sheet->mergeCells('B65:E65');
        $sheet->mergeCells('B66:E66');
        $sheet->mergeCells('B68:D68');
        $sheet->mergeCells('B69:E69');
        $sheet->mergeCells('B78:D78');
        $sheet->mergeCells('B79:D79');
        $sheet->mergeCells('B80:E80');
        $sheet->mergeCells('B81:E81');
        $sheet->mergeCells('B83:D83');

        $sheet->mergeCells('B84:E84');
        $sheet->mergeCells('B86:D86');
        $sheet->mergeCells('B87:D87');
        $sheet->mergeCells('B88:E88');
        $sheet->mergeCells('B89:D89');
        $sheet->mergeCells('B90:E90');

        $sheet->mergeCells('B91:E91');
        $sheet->mergeCells('B100:D100');
        $sheet->mergeCells('B101:D101');
        $sheet->mergeCells('B102:E102');

        $sheet->mergeCells('B103:E103');
        $sheet->mergeCells('B111:D111');
        $sheet->mergeCells('B112:E112');
        $sheet->mergeCells('B119:D119');
        $sheet->mergeCells('B120:D120');

        $sheet->mergeCells('B121:E121');
        $sheet->mergeCells('B122:D122');
        $sheet->mergeCells('B123:E123');
        $sheet->mergeCells('B124:E124');
        $sheet->mergeCells('B126:D126');
        $sheet->mergeCells('B127:D127');
    }

    public function columnFormats(): array
    {
        // Define column widths
        return [
            'A' => 'General',
            'B' => '@',
            'C' => 'General',
            'D' => 'General',
            'E' => 'General',
        ];
    }
}
