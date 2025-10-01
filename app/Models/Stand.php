<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    public $timestamps = false;
    protected $fillable = ['nom_stand', 'description', 'image_url', 'utilisateur_id'];
    public function produits()
    {
        return $this->hasMany(Produits::class);
    }
}