<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Afficher tous les utilisateurs.
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Afficher un utilisateur spécifique.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Créer un nouvel utilisateur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,user',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json($user, 201);
    }

    /**
     * Mettre à jour un utilisateur.
     */

     public function update(Request $request, $id)
    {
        // Valider les données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:' . User::ROLE_ADMIN . ',' . User::ROLE_USER,
        ]);

        // Trouver l'utilisateur
        $user = User::findOrFail($id);

        // Mettre à jour les informations
        $user->update($validatedData);

        return response()->json($user, 200);
    }




    

    

    /**
     * Supprimer un utilisateur.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès.'], 200);
    }
}
