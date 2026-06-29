<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concessionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'siege_social',
        'description',
        'logo',
        'cover',
        'adresse',
        'adresse_map',
        'longitude',
        'latitude',
        'userconcessionnaire_id',
        'pays_id',
        'ville_id',
        'commune_id',
        'is_whatsapp',
        'mobile_fix',
    ];

}
