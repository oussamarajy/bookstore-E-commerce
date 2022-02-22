<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auteur extends Model
{
    protected $fillable = ['nom', 'slug', 'image', 'bio'];
    use HasFactory;
}
