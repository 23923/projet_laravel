<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import nécessaire pour HasFactory
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    // Définir les attributs massivement assignables
    protected $fillable = [
        'name',
        'image',
    ];

    // Définir la relation avec d'autres modèles (si applicable)
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
