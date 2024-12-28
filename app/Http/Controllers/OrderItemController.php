<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Afficher la liste des articles de commande.
     */
    public function index()
    {
        try {
            $orderItems = OrderItem::with(['order', 'item'])->get();

            if ($orderItems->isEmpty()) {
                return response()->json(['message' => 'Aucun article de commande trouvé'], 404);
            }

            return response()->json($orderItems, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des articles de commande.'], 500);
        }
    }

    /**
     * Créer un nouvel article de commande.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'item_id' => 'required|exists:items,id',
                'price' => 'required|numeric',
                'quantity' => 'required|integer|min:1',
            ]);

            // Création de l'article de commande
            $orderItem = OrderItem::create($validatedData);

            return response()->json([
                'message' => 'Article de commande créé avec succès.',
                'order_item' => $orderItem
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de l’article de commande.'], 500);
        }
    }

    /**
     * Afficher les détails d'un article de commande.
     */
    public function show(OrderItem $orderItem)
    {
        try {
            $orderItem->load(['order', 'item']);

            return response()->json($orderItem, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des détails de l’article de commande.'], 500);
        }
    }

    /**
     * Mettre à jour un article de commande existant.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'order_id' => 'sometimes|exists:orders,id',
                'item_id' => 'sometimes|exists:items,id',
                'price' => 'sometimes|numeric',
                'quantity' => 'sometimes|integer|min:1',
            ]);

            // Mise à jour de l'article de commande
            $orderItem->update($validatedData);

            return response()->json([
                'message' => 'Article de commande mis à jour avec succès.',
                'order_item' => $orderItem
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de l’article de commande.'], 500);
        }
    }

    /**
     * Supprimer un article de commande.
     */
    public function destroy(OrderItem $orderItem)
    {
        try {
            $orderItem->delete();

            return response()->json(['message' => 'Article de commande supprimé avec succès.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de l’article de commande.'], 500);
        }
    }
}
