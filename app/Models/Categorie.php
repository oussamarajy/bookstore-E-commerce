<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['titre_cat', 'slug_cat', 'Description', 'image'];
    use HasFactory;
}
