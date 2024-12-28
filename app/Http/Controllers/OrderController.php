<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        try {
            // Récupérer toutes les commandes avec leurs utilisateurs et leurs éléments associés
            $orders = Order::with(['User', 'orderItems'])->get();

            if ($orders->isEmpty()) {
                return response()->json(['error' => 'Aucune commande trouvée'], 404);
            }

            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération des commandes'], 500);
        }
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'created_date' => 'required|date_format:Y-m-d', // Format attendu : AAAA-MM-JJ
            ]);
            

            // Création de la commande
            $order = Order::create($validatedData);

            return response()->json([
                'message' => 'Commande créée avec succès.',
                'order' => $order
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la création de la commande'], 500);
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        try {
            // Charger les relations utilisateur et éléments de commande
            $order->load(['appUser', 'orderItems']);

            return response()->json([
                'message' => 'Détails de la commande récupérés avec succès.',
                'order' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la récupération de la commande'], 500);
        }
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            // Validation des données
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'created_date' => 'required|date_format:Y-m-d', // Format attendu : AAAA-MM-JJ
            ]);
            

            // Mise à jour de la commande
            $order->update($validatedData);

            return response()->json([
                'message' => 'Commande mise à jour avec succès.',
                'order' => $order
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la mise à jour de la commande'], 500);
        }
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy(Order $order)
    {
        try {
            // Supprimer la commande
            $order->delete();

            return response()->json([
                'message' => 'Commande supprimée avec succès.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression de la commande'], 500);
        }
    }
}
