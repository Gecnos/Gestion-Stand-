<?php


namespace App\Http\Controllers;

use App\Mail\Appel;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeApprouvee;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Mail\DemandeRejete;
use App\Mail\Desuspension;
use App\Mail\Suspension;

class AdminController extends Controller
{
    public function index()
    {
        $demandes = User::where('role', 'pending')->get();
        $nbDemandes = $demandes->count();
        $nbExposants = User::where('role', 'approuve')->count();
        $nbCommandes = Commande::count();
        $chiffreAffaires = Commande::sum('total');;
        $entrepreneurs = User::where('role', 'approuve')->get();
        $entrepreneurs_rejetes = User::where('role', 'reject')->get();
        $entrepreneurs_suspendus = User::where('role', 'suspendu')->get();

        return view('admin.dashboard', compact('demandes', 'nbDemandes', 'nbExposants', 'nbCommandes', 'chiffreAffaires', 'entrepreneurs', 'entrepreneurs_rejetes', 'entrepreneurs_suspendus'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'approuve';
        $user->motif_rejet = null;
        $user->save();

        Mail::to($user->email)->send(new DemandeApprouvee($user));

        return back()->with('success', 'Demande approuvée.');
    }

    public function reject(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->role = 'rejete';
        $user->motif_rejet = $request->input('motif');
        $user->save();

        Mail::to($user->email)->send(new DemandeRejete($user));


        return back()->with('error', 'Demande rejetée.');
    }

    public function suspendre($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'suspendu';
        $user->save();

        Mail::to($user->email)->send(new Suspension($user));

        return redirect()->back()->with('success', 'Utilisateur suspendu .');
    }
    public function desuspendre($id)
    {
        $user = User::findOrFail($id);
        $user->role = 'approuve';
        $user->save();

        Mail::to($user->email)->send(new Desuspension($user));

        return redirect()->back()->with('success', 'Utilisateur désuspendu.');
    }
    public function faireAppel($id)
    {
        $user = User::findOrFail($id);
        if ($user->role == 'rejete') {
            $user->role = 'pending';
            $user->save();
        }
        Mail::to($user->email)->send(new Appel($user));

        return redirect()->back()->with('success', 'L’utilisateur a été remis en attente pour réexamen.');
    }
}
