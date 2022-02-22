<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['id_livre', 'reduction', 'citation', 'affichage'];
    use HasFactory;
}
