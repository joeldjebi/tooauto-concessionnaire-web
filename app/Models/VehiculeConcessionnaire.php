<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehiculeConcessionnaire extends Model
{
    use HasFactory;
    
    protected $table = 'vehicule_concessionnaires';
    
    protected $fillable = [
        'name',
        'concessionnaire_id',
        'marque_id',
        'modele',
        'prix',
        'description',
        'photos',
        'fichier',
        'garantie'
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    // Relation avec la marque
    public function marque()
    {
        return $this->belongsTo(Marque::class);
    }

    // Relation avec le concessionnaire (si vous avez ce modèle)
    public function concessionnaire()
    {
        return $this->belongsTo(Concessionnaire::class);
    }
}
