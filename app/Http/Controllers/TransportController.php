<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
{
    $transports = Transport::with(['driver', 'vehicle'])
                ->latest()
                ->paginate(10);
    
    return view('transport.index', compact('transports'));
}
    //
}
