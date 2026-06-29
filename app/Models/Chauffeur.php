<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chauffeur extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'fonction_id',
        'gestionnaire_de_flotte_id',
        'statut',
        'date_embauche',
        'numero_permis',
        'date_expiration_permis'
    ];

    // Relation avec la fonction
    public function fonction()
    {
        return $this->belongsTo(Fonction::class);
    }

    // Relation avec le gestionnaire de flotte
    public function gestionnaire_de_flotte()
    {
        return $this->belongsTo(GestionnaireDeFlotte::class);
    }

    // Relation avec les véhicules
    public function vehicules()
    {
        return $this->hasMany(Vehicule::class, 'chauffeur_id');
    }
}
