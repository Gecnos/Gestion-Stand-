<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    public function produits()
    {
        return $this->hasMany(Produits::class);
    }
}