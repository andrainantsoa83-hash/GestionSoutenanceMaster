<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Critere;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CritereController extends Controller
{
    /**
     * Afficher tous les critères.
     */
    public function index(): JsonResponse
    {
        $criteres = Critere::with('grilleEvaluation')
            ->orderBy('libelle')
            ->get();

        return response()->json($criteres);
    }

    /**
     * Créer un nouveau critère.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:255',
            'description' => 'nullable|string',
            'actif' => 'required|boolean',
            'grille_evaluation_id' => 'required|exists:grille_evaluations,idGrille',
        ]);

        $critere = Critere::create($validated);

        return response()->json(
            $critere->load('grilleEvaluation'),
            201
        );
    }

    /**
     * Afficher un critère précis.
     */
    public function show(Critere $critere): JsonResponse
    {
        return response()->json(
            $critere->load([
                'grilleEvaluation',
                'bareme',
                'coefficient',
            ])
        );
    }

    /**
     * Modifier un critère.
     */
    public function update(
        Request $request,
        Critere $critere
    ): JsonResponse {
        $validated = $request->validate([
            'libelle' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'actif' => 'sometimes|required|boolean',
            'grille_evaluation_id' => 'sometimes|required|exists:grille_evaluations,idGrille',
        ]);

        $critere->update($validated);

        return response()->json(
            $critere->load('grilleEvaluation')
        );
    }

    /**
     * Supprimer un critère.
     */
    public function destroy(Critere $critere): JsonResponse
    {
        $critere->delete();

        return response()->json([
            'message' => 'Critère supprimé avec succès.'
        ]);
    }
}