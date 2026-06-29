<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rdv_concessionnaire extends Model
{
    use HasFactory;
    
    protected $table = 'rdv_concessionnaires';
    
    protected $fillable = [
        'concessionnaire_id',
        'user_id',
        'gestionnaire_de_flotte_id',
        'statut',
        'jour',
        'heure',
        'reponse_concessionnaire'
    ];

    protected $casts = [
        'heure' => 'string', // La table stocke l'heure comme varchar(20)
    ];

    // Relation avec le concessionnaire
    public function concessionnaire()
    {
        return $this->belongsTo(User::class, 'concessionnaire_id');
    }

    // Relation avec l'utilisateur (user_id)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec le gestionnaire de flotte
    public function gestionnaireDeFlotte()
    {
        return $this->belongsTo(GestionnaireDeFlotte::class, 'gestionnaire_de_flotte_id');
    }
}