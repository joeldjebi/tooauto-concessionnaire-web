<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'libelle',
        'description',
        'statut'
    ];

    // Relation avec les chauffeurs
    public function chauffeurs()
    {
        return $this->hasMany(Chauffeur::class);
    }
}
