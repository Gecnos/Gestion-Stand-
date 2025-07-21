<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function index()
    {
        $stands = Stand::all();
        return view('stands.index', compact('stands'));
    }
    public function show($id)
    {
        $stand = Stand::with('produits')->findOrFail($id);

        return view('stands.show', compact('stand'));
    }
}
