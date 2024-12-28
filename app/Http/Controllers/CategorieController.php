<?php
namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    /**
     * Afficher la liste des catégories.
     */
    public function index()
    {
        try {
            $categories = Categorie::all(); // Récupère toutes les catégories
            if ($categories->isEmpty()) {
                return response()->json(['error' => 'Aucune catégorie trouvée'], 404);
            }
            return response()->json($categories, 200); // Renvoie les catégories en JSON
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problème de récupération des données'], 500);
        }
    }
    

    /**
     * Créer une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            // Vérifier si un fichier image a été téléchargé
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // Stocker l'image dans le dossier 'images' du stockage
                $imagePath = $image->store('images', 'public');
            }

            // Créer une nouvelle catégorie
            $categorie = new Categorie([
                'name' => $request->input('name'),
                'image' => $imagePath, // Enregistrer le chemin de l'image
            ]);

            // Sauvegarder la catégorie dans la base de données
            $categorie->save();

            return response()->json($categorie, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Insertion impossible'], 500);
        }
    }

    /**
     * Afficher une catégorie spécifique.
     */
    public function show($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);

            // Vérifier si l'image existe dans la base de données
            if ($categorie->image) {
                // Renvoyer l'image en utilisant l'URL de stockage public
                return response()->json([
                    'name' => $categorie->name, // Afficher le nom de la catégorie
                    'image_url' => Storage::url($categorie->image) // Afficher l'URL de l'image
                ], 200);
            } else {
                return response()->json(['error' => 'Image non trouvée'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problème de récupération des données'], 404);
        }
    }

    /**
     * Mettre à jour une catégorie spécifique.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:50|unique:categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->name = $request->input('name', $categorie->name);

            if ($request->hasFile('image')) {
                // Si une nouvelle image est téléchargée, on la stocke et met à jour le chemin
                $imagePath = $request->file('image')->store('images', 'public');
                $categorie->image = $imagePath;
            }

            $categorie->save();
            return response()->json($categorie, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problème de modification'], 500);
        }
    }

    /**
     * Supprimer une catégorie spécifique.
     */
    public function destroy($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);

            // Supprimer l'image du stockage si elle existe
            if ($categorie->image) {
                Storage::delete($categorie->image);
            }

            $categorie->delete();

            return response()->json(['message' => 'Catégorie supprimée avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Problème de suppression de catégorie'], 500);
        }
    }
}
