<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Table associée (optionnel, si le nom de la table ne suit pas la convention Laravel)
    protected $table = 'order_items';

    // Définir les champs autorisés pour l'assignation de masse
    protected $fillable = [
        'order_id', 
        'item_id', 
        'price', 
        'quantity',
    ];

    // Relation avec Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relation avec Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
