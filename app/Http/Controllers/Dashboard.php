<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Dashboard extends Controller
{
    public function index()
    {
        $user = Auth::user();
        Log::info('Dashboard access by user:', ['user_id' => $user->id, 'role' => $user->role]);

        if ($user->role === 'admin') {
            Log::info('Redirecting to admin.dashboard');
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'approuve') {
            Log::info('Redirecting to entrepreneur dashboard or create page');
            // Check s’il a un stand
            if (!$user->stand) {
                return redirect()->route('entrepreneur.create');
            }
            return redirect()->route('entrepreneur.dashboard');
        }

        Log::info('Redirecting to attente page');
        return redirect()->route('attente');
    }
}
