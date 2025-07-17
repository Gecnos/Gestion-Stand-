<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemandeStandController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('nom'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'pending',
        ]);


        Mail::raw("Nouvelle demande de stand de : {$user->name} ({$user->email})", function ($message) use ($user) {
            $message->to('admin@eatdrink.com')
                    ->subject('Nouvelle demande de stand Eat&Drink')
                    ->from($user->email);
        });

        return redirect('/')->with('success', 'Votre demande a bien été envoyée. Vous serez notifié par email une fois validée.');
    }
}
