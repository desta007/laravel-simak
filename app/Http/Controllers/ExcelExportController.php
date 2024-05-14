<?php

namespace App\Http\Controllers;

use App\Exports\ExportNeraca;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    public function exportNeraca()
    {
        // contek skrip dari neracaSearch
        $data = [
            ['Name', 'Email'],                // Column headers
            ['John Doe', 'john@example.com'], // Data row 1
            ['Jane Doe', 'jane@example.com'], // Data row 2
        ];

        return Excel::download(new ExportNeraca($data), 'neraca.xlsx');
    }
}
