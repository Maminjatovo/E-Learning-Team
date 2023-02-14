<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admininstarateur extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'nom_admin',
        'prenom_admin',
        'adress_admin',
        'tel_admin',
        'email_admin',
        'password_admin',
        'photo_admin'
    ];
}
