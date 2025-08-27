<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    /**
     * Display the scan page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $apiaries = \App\Models\Apiary::where('user_id', auth()->id())->get();
        return view('scan.index', compact('apiaries'));
    }
}
