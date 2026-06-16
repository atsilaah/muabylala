<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferensiController extends Controller
{
    public function index(Request $request)
    {
        $tema = $request->cookie('tema', 'light');
        $font = $request->cookie('font', 'medium');
        return view('preferensi', compact('tema', 'font'));
    }

    public function update(Request $request)
    {
        $tema = $request->input('tema', 'light');
        $font = $request->input('font', 'medium');

        return response()
            ->json(['status' => 'ok', 'tema' => $tema, 'font' => $font])
            ->cookie('tema', $tema, 60 * 24 * 30)
            ->cookie('font', $font, 60 * 24 * 30);
    }
}
