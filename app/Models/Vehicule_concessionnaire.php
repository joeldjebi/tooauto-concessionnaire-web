<?php

// app/Models/VehiculeConcessionnaire.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule_concessionnaire extends Model
{
    protected $fillable = [
        'name', 'concessionnaire_id', 'marque_id', 'modele',
        'prix', 'description', 'photos', 'fichier', 'garantie'
    ];

    protected $casts = [
        'photos' => 'array' // Pour stocker les photos en JSON
    ];

    public function concessionnaire()
    {
        return $this->belongsTo(Concessionnaire::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

}