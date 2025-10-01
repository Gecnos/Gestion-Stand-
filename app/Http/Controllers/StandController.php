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
            'nom_stand'   => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload si une image est présente
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('stands', 'public');
            $validated['image_url'] = 'storage/' . $path;
        }

        $validated['utilisateur_id'] = Auth::id();
        // Le stand est mis en 'en_attente' ou 'approuve' par défaut selon votre business logic
        // Pour cet exemple, on suppose qu'il a un statut
        $validated['statut'] = 'approuve'; 
        
        Stand::create($validated);

        return redirect()->route('entrepreneur.dashboard')
            ->with('success', 'Stand créé avec succès !');
    }


    public function create()
    {
        return view('entrepreneur.create');
    }
    public function createProduct()
    {
        $stand = Auth::user()->stand;
        if (!$stand) {
            return redirect()->route('entrepreneur.create')->with('error', 'Vous devez d\'abord créer un stand.');
        }
        return view('products.create', ['standId' => $stand->id]);
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stand_id' => 'required|exists:stands,id'
        ]);

        $stand = Auth::user()->stand;

        // Vérifier que le stand_id du formulaire correspond bien au stand de l'utilisateur authentifié
        if ($stand->id != $request->input('stand_id')) {
            return back()->with('error', 'Action non autorisée.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Produits::create([
            'nom' => $request->name,
            'description' => $request->description,
            'prix' => $request->price,
            'image_url' => $imagePath,
            'stand_id' => $stand->id,
        ]);

        return redirect()->route('entrepreneur.dashboard')->with('success', 'Produit ajouté avec succès !');
    }

    public function orders()
    {
        $stand = Auth::user()->stand;
        if (!$stand) {
            return redirect()->route('entrepreneur.create')->with('error', 'Vous devez avoir un stand pour voir les commandes.');
        }

        $orders = Commande::where('stand_id', $stand->id)->with('user')->latest()->get();

        return view('orders.index', ['orders' => $orders, 'stand' => $stand]);
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
            // On s'attend à 'nom_complet' et 'email' dans le formulaire de stand
            'nom_complet' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
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
            'client' => [
                'nom_complet' => $request->input('nom_complet'),
                'email' => $request->input('email'),
                'user_id_guest_or_auth' => Auth::id() ?? session('guest_id'),
            ]
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

    public function dashboard()
    {
        $user = Auth::user();

        // Vérifie si l'utilisateur a un stand (relation 'stand' nécessaire dans User.php)
        $stand = $user->stand; 

        if (!$stand) {
            // Pas encore de stand → redirection vers la page de création
            return redirect()->route('entrepreneur.create')
                ->with('info', 'Veuillez créer votre stand pour accéder au tableau de bord.');
        }
        
        // --- Récupération des données réelles ---
        
        // 1. Nombre de produits
        $productsCount = $stand->produits()->count();
        
        // 2. Commandes (On filtre pour les commandes du stand et qui ne sont pas annulées)
        $orders = Commande::where('stand_id', $stand->id)
                          ->where('statut', '!=', 'annulee')
                          ->get();

        $ordersCount = $orders->count();
        
        // 3. Chiffre d'affaires (Total des commandes 'payee' ou 'livree')
        $revenue = $orders->whereIn('statut', ['payee', 'livree'])->sum('total');

        // 4. Visibilité (statut du stand)
        $visibility = ($stand->statut == 'approuve' || $stand->statut == 'publie') ? 'Public' : 'Privé / En Attente';
        
        // 5. Statut d'approbation pour la bannière
        $isApproved = $stand->statut == 'approuve' || $stand->statut == 'publie';

        // Si le stand existe → affiche le dashboard avec les infos du stand
        return view('entrepreneur.dashboard', [ // Utilisation de 'dashboard' ici car votre vue est nommée ainsi
            'stand' => $stand,
            'standName' => $stand->nom_stand,
            'productsCount' => $productsCount,
            'ordersCount' => $ordersCount,
            'revenue' => $revenue,
            'visibility' => $visibility,
            'isApproved' => $isApproved,
        ]);
    }
}
