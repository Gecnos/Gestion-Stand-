<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $fillable = ['nom_stand', 'description', 'image_url', 'user_id'];
    public function produits()
    {
        return $this->hasMany(Produits::class);
    }
}