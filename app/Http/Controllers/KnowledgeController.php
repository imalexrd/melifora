<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index()
    {
        return view('knowledge.index');
    }
}
