<?php


namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeApprouvee;

class AdminController extends Controller
{
    public function index()
    {
        $demandes = User::where('role', 'pending')->get();
        return view('admin.dashboard', compact('demandes'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'approuve';
        $user->save();

        Mail::to($user->email)->send(new DemandeApprouvee($user));

        return back()->with('success', 'Demande approuvée.');
    }

    public function reject($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('error', 'Demande rejetée.');
    }
}
