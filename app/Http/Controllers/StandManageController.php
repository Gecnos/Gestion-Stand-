<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produits;
use App\Models\Commande;

class StandManageController extends Controller
{
    public function ajouter(Request $request)
    {
        $produits = Produits::findOrFail($request->produits_id);

        $panier = session()->get('panier', []);
        $panier[$produits->id] = [
            'nom' => $produits->nom,
            'prix' => $produits->prix,
            'quantite' => ($panier[$produits->id]['quantite'] ?? 0) + 1,
        ];

        session()->put('panier', $panier);
        return back()->with('success', 'Produit ajouté au panier.');
    }

    public function voir()
    {
        $panier = session('panier', []);
        return view('panier.index', compact('panier'));
    }

    public function supprimer($id)
    {
        $panier = session()->get('panier', []);
        unset($panier[$id]);
        session()->put('panier', $panier);

        return back()->with('success', 'Produit retiré.');
    }
    public function passerCommande(Request $request)
    {
        $panier = session()->get('panier', []);
        if (empty($panier)) {
            return back()->withErrors('Votre panier est vide.');
        }

        $total = array_sum(array_map(fn($item) => $item['prix'] * $item['quantite'], $panier));

        $commande = Commande::create([
            'user_id' => auth()->id,
            'stand_id' => $request->stand_id,
            'statut' => 'en_attente',
            'montant' => $total,
            'total' => $total,
            'details_commande' => json_encode($panier),
            'date_commande' => now(),
        ]);

        session()->forget('panier');

        return redirect()->route('vitrine')->with('success', 'Commande passée avec succès !');
    }
}
