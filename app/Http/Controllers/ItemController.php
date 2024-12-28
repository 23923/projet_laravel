<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    // Liste tous les items
    public function index()
    {
        return response()->json([
            'message' => 'Liste des articles récupérée avec succès.',
            'data' => Item::all(),
        ]);
    }

    // Crée un nouvel item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomart' => 'required|string|max:100',
            'prixUnitaire' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'imageart' => 'nullable|string|max:255',
            'categorie_id' => 'required|integer|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        $item = Item::create($validated);

        return response()->json([
            'message' => 'Article créé avec succès.',
            'data' => $item,
        ], 201);
    }

    // Affiche un item spécifique
    public function show(Item $item)
    {
        return response()->json([
            'message' => 'Article récupéré avec succès.',
            'data' => $item,
        ]);
    }

    // Met à jour un item
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'nomart' => 'sometimes|required|string|max:100',
            'prixUnitaire' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'imageart' => 'nullable|string|max:255',
            'categorie_id' => 'sometimes|required|integer|exists:categories,id',
            'is_active' => 'boolean',
        ]);

        $item->update($validated);

        return response()->json([
            'message' => 'Article mis à jour avec succès.',
            'data' => $item,
        ]);
    }

    // Supprime un item
    public function destroy($id)
    {            $item = Item::findOrFail($id);

        try {
            $item = Item::findOrFail($id);

            

            $item->delete();

            return response()->json(['message' => 'Article supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problème de suppression Article'], 500);
        }
    }}
