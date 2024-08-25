<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $tags = Status::where('user_id', 1)->get();
        $data = [
            'tags' => $tags
        ];
        $pdf = Pdf::loadView('pdf.index', $data);
        return $pdf->download('test.pdf');

    }

    public function index(){
        return view('pdf.index');
    }

}
