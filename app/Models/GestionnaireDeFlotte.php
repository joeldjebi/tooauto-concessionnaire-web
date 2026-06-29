<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionnaireDeFlotte extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'entreprise',
        'statut'
    ];

    // Relation avec les véhicules
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class);
    }

    // Relation avec les chauffeurs
    public function chauffeurs()
    {
        return $this->hasMany(Chauffeur::class);
    }
}