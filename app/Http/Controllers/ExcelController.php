<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function index(){
        $tags = Status::all();
        return view('excel.index', ['tags' => $tags]);
    }
}
