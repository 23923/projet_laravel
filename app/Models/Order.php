<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Table associée (optionnel, si le nom de la table ne suit pas la convention Laravel)
    protected $table = 'orders';

    // Définir les champs autorisés pour l'assignation de masse
    protected $fillable = [
        'created_date', 
        'user_id', // Clé étrangère vers AppUser
    ];

    // Relation avec AppUser
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relation avec OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
