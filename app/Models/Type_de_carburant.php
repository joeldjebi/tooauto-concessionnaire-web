<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_de_carburant extends Model
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