<?php

namespace App\Http\Controllers;

use App\Models\Stand;
use App\Models\Produits;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// J'ai renommé le contrôleur en CartController pour mieux correspondre aux méthodes de panier/commande.
// Si ce fichier contient aussi les méthodes stand.index et stand.show, le nom d'origine peut être conservé.
// Pour l'exemple, nous allons le laisser StandController et le corriger.

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

    /**
     * Ajoute un produit au panier de la session, groupé par stand.
     * Utilise la clé 'prix' et 'nom' pour l'enregistrement.
     */
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantity' => 'required|integer|min:1',
            // Ajout de la validation pour les champs cachés envoyés par la vue show.blade.php
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
                // CORRECTION: Utiliser 'nom' et 'prix' pour la session
                'name' => $validated['name'], // Nom du produit (utilisé dans la vue)
                'prix' => $validated['prix'], // Prix du produit (utilisé pour les calculs)
                'quantity' => $validated['quantity'],
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier!');
    }


    /**
     * Finalise et enregistre la commande pour un stand spécifique.
     * Utilise la clé 'prix' pour le calcul.
     */
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
            // CORRECTION DE ROBUSTESSE: Détecte et utilise la clé de prix existante ('prix' ou 'price')
            $itemPrice = $item['prix'] ?? $item['price'] ?? 0;
            
            $subtotal = $itemPrice * $item['quantity'];
            $total += $subtotal;
            $details[] = [
                'produit_name' => $item['name'] ?? 'Nom Inconnu', // Utiliser 'name' ou fallback
                'quantity' => $item['quantity'],
                'price' => $itemPrice, // Clé standardisée pour le stockage dans la BDD
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
                // Si l'utilisateur est connecté, on utilise son ID, sinon c'est NULL
                'user_id' => Auth::id(),
                'stand_id' => $standId,
                'statut' => 'en_attente_paiement',
                'montant' => $total,
                'total' => $total,
                // On stocke les informations du client invité dans details_commande
                'details_commande' => json_encode($orderDetails),
                'date_commande' => Carbon::now(),
            ]);

            // Vider le panier de ce stand après succès
            unset($cart[$standId]);
            session()->put('cart', $cart);

            return redirect()->route('stands.show', $standId)
                ->with('success', 'Commande #' . $commande->id . ' enregistrée avec succès!');
        } catch (\Exception $e) {
             // Log de l'erreur pour le débogage
            // \Log::error("Erreur d'enregistrement de commande: " . $e->getMessage()); 
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
