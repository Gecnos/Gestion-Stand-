<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use App\Models\Produits;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function createStand(Request $request)
    {
        $validated = $request->validate([
            'nom_stand' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image_url' => 'nullable|url',
        ]);
        $stand = new Stand($validated);
        $stand->user_id = Auth::id();
        $stand->save();
        return redirect()->route('entrepreneur.dashboard')->with('success', 'Stand créé avec succès !');
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer|min:1',
            'name' => 'required|string', 
            'prix' => 'required|numeric',
        ]);

        $produit = Produits::findOrFail($validated['produit_id']);
        $standId = $produit->stand_id;

        $cart = session()->get('cart', []);

        if (!isset($cart[$standId])) {
            $cart[$standId] = ['items' => [], 'stand_id' => $standId];
        }

        if (isset($cart[$standId]['items'][$produit->id])) {
            $cart[$standId]['items'][$produit->id]['quantity'] += $validated['quantity'];
        } else {
            $cart[$standId]['items'][$produit->id] = [
                
                'name' => $validated['name'], 
                'prix' => $validated['prix'], 
                'quantity' => $validated['quantity'],
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier!');
    }

    public function storeOrder(Request $request)
    {
        // Validation des champs nécessaires
        $request->validate([
            'stand_id' => 'required|exists:stands,id',
        ]);

        $standId = $request->input('stand_id');

        $cart = session()->get('cart', []);

        if (!isset($cart[$standId]) || empty($cart[$standId]['items'])) {
            return back()->with('error', 'Votre panier pour ce stand est vide.');
        }

        $standCart = $cart[$standId]['items'];
        $total = 0;
        $details = [];

        // Calcul du total et préparation des détails
        foreach ($standCart as $item) {

            $itemPrice = $item['prix'] ?? $item['price'] ?? 0;
            
            $subtotal = $itemPrice * $item['quantity'];
            $total += $subtotal;
            $details[] = [
                'produit_name' => $item['name'] ?? 'Nom Inconnu', 
                'quantity' => $item['quantity'],
                'price' => $itemPrice, 
                'subtotal' => $subtotal,
            ];
        }

        // Ajout des informations client aux détails pour un suivi facile
        $orderDetails = [
            'items' => $details,
        ];

        // Enregistrement de la Commande
        try {
            $commande = Commande::create([
                
                'user_id' => Auth::id(),
                'stand_id' => $standId,
                'statut' => 'en_attente_paiement',
                'montant' => $total,
                'total' => $total,
                
                'details_commande' => json_encode($orderDetails),
                'date_commande' => Carbon::now(),
            ]);

            // Vider le panier de ce stand après succès
            unset($cart[$standId]);
            session()->put('cart', $cart);

            return redirect()->route('stands.show', $standId)
                ->with('success', 'Commande #' . $commande->id . ' enregistrée avec succès!');
        } catch (\Exception $e) {

            return back()->with('error', 'Erreur lors de l\'enregistrement de la commande. Veuillez réessayer.');
        }
    }
    
    /**
     * Vide le panier pour un stand spécifique.
     */
    public function clearCart($standId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$standId])) {
            unset($cart[$standId]); // Supprime l'entrée complète du stand
            session()->put('cart', $cart);
            
            return back()->with('success', 'Le panier pour ce stand a été vidé avec succès.');
        }
        
        return back()->with('error', 'Le panier de ce stand est déjà vide.');
    }
}
