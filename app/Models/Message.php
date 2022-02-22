<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['client_id', 'email', 'titre', 'contenu', 'id_admin', 'to_id', 'from_id'];
}
