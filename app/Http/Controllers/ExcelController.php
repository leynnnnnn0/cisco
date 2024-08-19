<?php

namespace App\Http\Controllers;

use App\Exports\StatusExport;
use App\Models\Status;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function index(){
        $tags = Status::all();
        return view('excel.index', ['tags' => $tags]);
    }

    public function export()
    {
        return Excel::download(new StatusExport, 'users.xlsx');
    }
}
