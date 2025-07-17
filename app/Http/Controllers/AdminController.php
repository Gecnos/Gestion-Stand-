<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeApprouvee;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Mail\DemandeRejete;


class AdminController extends Controller
{
   public function index()
{
    $demandes = User::where('role', 'pending')->get();

    $nbDemandes = $demandes->count();
    $nbExposants = User::where('role', 'approuve')->count();
    $nbCommandes = Commande::count();
    $chiffreAffaires = Commande::sum('total'); 

    return view('admin.dashboard', compact('demandes', 'nbDemandes', 'nbExposants', 'nbCommandes', 'chiffreAffaires'));
}

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approuve';
        $user->role = 'approuve';
        $user->motif_rejet = null;
        $user->save();

        Mail::to($user->email)->send(new DemandeApprouvee($user));

        return back()->with('success', 'Demande approuvée.');
    }

    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejete';
        $user->motif_rejet = $request->input('motif');
        $user->save();

        Mail::to($user->email)->send(new DemandeRejete($user));

        return back()->with('error', 'Demande rejetée.');
    }
}
