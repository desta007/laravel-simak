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

class ExportNeraca implements FromArray, WithStyles, WithColumnFormatting, ShouldAutoSize, WithDrawings, WithColumnWidths
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        // return $this->data;

        $data = $this->data;
        unset($data[0]['id_cabang']); // Remove 'namaCabang' before returning

        return $data;
    }

    public function drawings()
    {
        if ($this->data[0]['id_cabang'] == 2) {
            $drawing = new Drawing();
            $drawing->setName('Company Logo');
            $drawing->setDescription('This is my company logo');
            $drawing->setPath(storage_path('app/public/ptsam.jpg')); // Ensure the image exists
            $drawing->setHeight(65); // Adjust the height as needed
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('A1'); // Position of the image
            return $drawing;
        }
        if ($this->data[0]['id_cabang'] == 3) {
            $drawing = new Drawing();
            $drawing->setName('Company Logo');
            $drawing->setDescription('This is my company logo');
            $drawing->setPath(storage_path('app/public/cvnimo.jpg')); // Ensure the image exists
            $drawing->setHeight(65); // Adjust the height as needed
            $drawing->setResizeProportional(true);
            $drawing->setCoordinates('A1'); // Position of the image
            return $drawing;
        } else {
            $drawing1 = new Drawing();
            $drawing1->setName('Company Logo');
            $drawing1->setDescription('This is my company logo');
            $drawing1->setPath(storage_path('app/public/ptsam.jpg')); // First image
            $drawing1->setHeight(65); // Adjust height
            $drawing1->setResizeProportional(true);
            $drawing1->setCoordinates('A1'); // Position of first image
            $drawing1->setOffsetX(5);
            $drawing1->setOffsetY(5);

            $drawing2 = new Drawing();
            $drawing2->setName('Second Image');
            $drawing2->setDescription('This is another image');
            $drawing2->setPath(storage_path('app/public/cvnimo.jpg')); // Second image
            $drawing2->setHeight(65); // Adjust height
            $drawing2->setResizeProportional(true);
            $drawing2->setCoordinates('C1'); // Position of second image (e.g., in column E)
            $drawing2->setOffsetX(5);
            $drawing2->setOffsetY(5);

            return [$drawing1, $drawing2]; // Return multiple drawings
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 6,
            'C' => 45  // Set width of column C
        ];
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

        $sheet->mergeCells('D1:E1');
        $sheet->mergeCells('D2:E2');
        $sheet->mergeCells('D3:E3');

        $sheet->mergeCells('A5:E5');
        $sheet->getStyle('A5:E5')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B6:E6');
        $sheet->mergeCells('B12:D12');

        $sheet->mergeCells('B34:D34');
        $sheet->mergeCells('B46:D46');
        $sheet->mergeCells('B58:D58');
        $sheet->mergeCells('B68:D68');
        $sheet->mergeCells('B73:D73');
        $sheet->mergeCells('B79:D79');

        $sheet->mergeCells('B80:D80');
        $sheet->getStyle('B80:D80')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B81:E81');
        $sheet->mergeCells('B86:D86');
        $sheet->getStyle('B86:D86')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B87:E87');
        $sheet->mergeCells('B98:D98');
        $sheet->getStyle('B98:D98')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B99:E99');
        $sheet->mergeCells('B103:D103');
        $sheet->getStyle('B103:D103')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B104:E104');
        $sheet->mergeCells('B111:D111');
        $sheet->getStyle('B111:D111')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B112:E112');
        $sheet->mergeCells('B126:D126');
        $sheet->getStyle('B126:D126')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B127:D127');
        $sheet->getStyle('B127:D127')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('A128:E128');
        $sheet->mergeCells('A129:E129');
        $sheet->getStyle('A129:E129')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B130:E130');
        $sheet->mergeCells('B144:D144');
        $sheet->mergeCells('B162:D162');
        $sheet->mergeCells('B177:D177');
        $sheet->mergeCells('B188:D188');
        $sheet->getStyle('B188:D188')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B205:D205');
        $sheet->mergeCells('B206:D206');
        $sheet->getStyle('B206:D206')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B216:D216');
        $sheet->mergeCells('B217:D217');
        $sheet->getStyle('B217:D217')->getAlignment()->setHorizontal('center');

        $sheet->mergeCells('B225:D225');
        $sheet->mergeCells('B227:D227');
        $sheet->mergeCells('B229:D229');
        $sheet->mergeCells('B230:D230');
        $sheet->getStyle('B230:D230')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('B231:D231');
        $sheet->getStyle('B231:D231')->getAlignment()->setHorizontal('center');
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
