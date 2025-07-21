<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Commande extends Model
{
    use HasFactory;

    protected $table = 'commandes';

    protected $fillable = [
        'user_id',
        'stand_id',
        'statut',
        'montant',
        'total',
        'details_commande',
        'date_commande',
    ];

    protected $dates = [
        'date_commande',
        'created_at',
        'updated_at',
    ];
    public function produits()
    {
        return $this->hasMany(Produits::class, 'commande_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class, 'stand_id');
    }
}
