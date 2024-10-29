<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        return view('konfigurasi.lokasikantor');
    } 
}
