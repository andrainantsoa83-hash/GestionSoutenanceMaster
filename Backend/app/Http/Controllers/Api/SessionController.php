<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Afficher toutes les sessions.
     */
    public function index(): JsonResponse
    {
        $sessions = Session::orderBy('date_debut', 'desc')->get();

        return response()->json($sessions);
    }

    /**
     * Créer une nouvelle session.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'statut' => 'required|string|max:50',
        ]);

        $session = Session::create($validated);

        return response()->json($session, 201);
    }

    /**
     * Afficher une session précise.
     */
    public function show(Session $session): JsonResponse
    {
        return response()->json($session);
    }

    /**
     * Modifier une session.
     */
    public function update(Request $request, Session $session): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'date_debut' => 'sometimes|required|date',
            'date_fin' => 'sometimes|required|date|after_or_equal:date_debut',
            'statut' => 'sometimes|required|string|max:50',
        ]);

        $session->update($validated);

        return response()->json($session);
    }

    /**
     * Supprimer une session.
     */
    public function destroy(Session $session): JsonResponse
    {
        $session->delete();

        return response()->json([
            'message' => 'Session supprimée avec succès.'
        ]);
    }
}