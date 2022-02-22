<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    protected $fillable = ['titre', 'slug', 'description', 'auteur_id', 'categorie_id', 'quantity', 'isbn', 'prix', 'nb_pages', 'date_pub', 'image'];
    use HasFactory;
}
