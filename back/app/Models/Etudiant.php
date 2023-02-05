<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_etu',
        'nom_etu',
        'prenom_etu',
        'adresse_etu',
        'telephone_etu',
        'email_etu',
        'photo_etu'
    ];
}
