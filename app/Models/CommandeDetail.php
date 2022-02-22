<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeDetail extends Model
{
    protected $fillable = ['commande_id', 'livre_id', 'quantity', 'prix_unitaire'];
    use HasFactory;
}
