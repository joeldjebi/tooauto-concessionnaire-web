<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'matricule',
        'carte_grise',
        'type_de_vehicule_id',
        'marque_id',
        'type_de_carburant_id',
        'couleur_vehicule_id',
        'user_id',
        'chauffeur_id',
        'modele',
        'gestionnaire_de_flotte_id',
        'photos',
        'statut'
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    // Relation avec le chauffeur
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class, 'chauffeur_id');
    }

    // Relation avec le type de véhicule
    public function type_de_vehicule()
    {
        return $this->belongsTo(Type_de_vehicule::class);
    }

    // Relation avec la marque
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    // Relation avec le type de carburant
    public function type_de_carburant()
    {
        return $this->belongsTo(Type_de_carburant::class);
    }

    // Relation avec la couleur du véhicule
    public function couleur_vehicule()
    {
        return $this->belongsTo(Couleur_vehicule::class);
    }

    // Relation avec le gestionnaire de flotte
    public function gestionnaire_de_flotte()
    {
        return $this->belongsTo(GestionnaireDeFlotte::class);
    }
}
