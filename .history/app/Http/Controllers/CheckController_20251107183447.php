<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function process(Request $request)
    {
        // nanti bagian ini buat proses JSON followers vs following
        return view('result', ['unfollowers' => []]);
    }
}
