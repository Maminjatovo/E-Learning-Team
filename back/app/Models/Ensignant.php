<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ensignant extends Model
{
    use HasFactory;


    protected $fillable = [
        'nom_ens',
        'prenom_ens',      
        'adresse_ens',
        'telephone_ens',
        'photo_ens',
        'email_ens',
        'specialite_ens',
    ];
}
