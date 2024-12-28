<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // Table associée
    protected $table = 'items';

    // Colonnes modifiables en masse
    protected $fillable = [
        'nomart',
        'prixUnitaire',
        'description',
        'imageart',
        'categorie_id',
        'is_active',
    ];

    // Relation avec la table 'categories'
    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
}
