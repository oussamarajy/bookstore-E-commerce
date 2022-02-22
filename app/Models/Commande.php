<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['client_id' , 'ship_nom' , 'ship_prenom', 'shipadresse', 'ship_ville', 'ship_region' , 'ship_code_postal', 'ship_phone'];
    use HasFactory;
}
