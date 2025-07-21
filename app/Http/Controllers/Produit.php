<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produits;


class Produit extends Controller
{
    //Ici c'est l'index pour afficher les informations comme le nom du produits et tout ça , quand on veut afficher quelque chose dans le controller on l'appel dans l'index et on le retourne compact
    public function index()
    {
        $stand = Auth::user()->stand;
        $produits = $stand ? $stand->produits : [];
        return view('entrepreneur.produits.index', compact('produits'));
    }

    public function create()
    {
       return view('entrepreneur.produits.create');
    }

    // Cette fonction sert à vérifier les valeurs des enregistrements et a les enregistrer d'où le validate
    public function store(Request $request)
    {
        $request->validate(
            [
                'nom' =>'required|string|max:255',
                'description' => 'required|string|max:1000',
                'prix' => 'required|numeric|min:0',
                'image_url' =>'nullable|url'
            ]);
        $stand = Auth::user()->stand;
        if (!$stand){
            return redirect()->back()->withErrors('Stand non trouvé');
        } 
        $stand->produits()->create($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit ajouté avec succès');   
    }

    public function edit(Produits $produits)
    {
        return view('entrepreneur.produits.edit', compact('produits'));
    }

    //Memme principe pour l'enregistrement d'un produit après sa création
    public function update(Request $request)
    {
        $request->validate(
        [
            'nom' =>'required|string|max:255',
            'description' => 'required|string|max:1000',
            'prix' => 'required|numeric|min:0',
            'image_url' =>'nullable|url'
        ]);
        $stand = Auth::user()->stand;
        if (!$stand) {
            return redirect()->back()->withErrors('Stand non trouvé');
        }
        $stand->produits()->update($request->all());
        return redirect()->route('produits.index')->with('success', 'Produit mis à jour.');

    }

    public function destroy(Produits $produits)
    {
        $stand = Auth::user()->stand;
        $stand->produits()->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé.');
    }
}
