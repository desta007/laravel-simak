<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportBukuTambahan implements FromArray, WithStyles, WithColumnFormatting, ShouldAutoSize, WithDrawings, WithColumnWidths
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $data = $this->data;
        unset($data[0]['id_cabang']);

        return $data;
    }

    public function drawings()
    {
        if ($this->data[0]['id_cabang'] == 2) {
            $drawing = new Drawing();
            $drawing->setName('Company Logo');
            $drawing->setDescription('This is my company logo');
            $drawing->setPath(storage_path('app/public/ptsam.jpg'));
            $drawing->setHeight(65);
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('A1');
            return $drawing;
        }
        if ($this->data[0]['id_cabang'] == 3) {
            $drawing = new Drawing();
            $drawing->setName('Company Logo');
            $drawing->setDescription('This is my company logo');
            $drawing->setPath(storage_path('app/public/cvnimo.jpg'));
            $drawing->setHeight(65);
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('A1');
            return $drawing;
        } else {
            $drawing1 = new Drawing();
            $drawing1->setName('Company Logo');
            $drawing1->setDescription('This is my company logo');
            $drawing1->setPath(storage_path('app/public/ptsam.jpg'));
            $drawing1->setHeight(65);
            $drawing1->setResizeProportional(true);
            $drawing1->setCoordinates('A1');
            $drawing1->setOffsetX(5);
            $drawing1->setOffsetY(5);

            $drawing2 = new Drawing();
            $drawing2->setName('Second Image');
            $drawing2->setDescription('This is another image');
            $drawing2->setPath(storage_path('app/public/cvnimo.jpg'));
            $drawing2->setHeight(65);
            $drawing2->setResizeProportional(true);
            $drawing2->setCoordinates('C1');
            $drawing2->setOffsetX(5);
            $drawing2->setOffsetY(5);

            return [$drawing1, $drawing2];
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 25,
            'C' => 25,
            'D' => 20,
            'E' => 30,
            'F' => 18,
            'G' => 18,
            'H' => 18,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = count($this->data);

        // Borders for data area (from header row 5 to last row)
        $sheet->getStyle('A5:H' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Merge cells for report header
        $sheet->mergeCells('D1:H1');
        $sheet->mergeCells('D2:H2');
        $sheet->mergeCells('D3:H3');
        $sheet->mergeCells('D4:H4');

        // Header row styling (row 5)
        $sheet->getStyle('A5:H5')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFDDDDDD'],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Saldo awal row styling (row 6)
        $sheet->getStyle('A6:H6')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF0F8FF'],
            ],
        ]);

        // Total row styling (last row)
        $sheet->getStyle('A' . $lastRow . ':H' . $lastRow)->applyFromArray([
            'font' => ['bold' => true],
        ]);

        // Right-align numeric columns (F, G, H)
        $sheet->getStyle('F5:H' . $lastRow)->getAlignment()->setHorizontal(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
        );

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'General',
            'B' => '@',
            'C' => '@',
            'D' => '@',
            'E' => '@',
            'F' => '#,##0',
            'G' => '#,##0',
            'H' => '#,##0',
        ];
    }
}
