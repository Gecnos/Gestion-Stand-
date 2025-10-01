<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'approuve') {
            // Check s’il a un stand
            if (!$user->stand) {
                return redirect()->route('entrepreneur.create');
            }
            return redirect()->route('entrepreneur.dashboard');
        }

        return redirect()->route('attente');
    }
}
