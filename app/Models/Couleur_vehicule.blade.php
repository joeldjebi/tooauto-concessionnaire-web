<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Couleur_vehicule extends Model
{
    use HasFactory;
    protected $fillable = [
        'libelle',
    ];

    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }
}