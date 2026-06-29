<?php

// app/Models/AnnonceConcessionnaire.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annonce_concessionnaire extends Model
{
    public function type_de_piece()
    {
        return $this->belongsTo(Type_de_piece::class);
    }

    public function type_de_vehicule()
    {
        return $this->belongsTo(Type_de_vehicule::class);
    }

    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function concessionaire()
    {
        return $this->belongsTo(Concessionaire::class);
    }

    public function gestionnaire_de_flotte()
    {
        return $this->belongsTo(GestionnaireDeFlotte::class,'gestionnaire_de_flotte_id');
    }

    public function type_de_demande()
    {
        return $this->belongsTo(Type_de_demande::class);
    }

}