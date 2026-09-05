<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GrilleEvaluation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrilleEvaluationController extends Controller
{
    /**
     * Afficher toutes les grilles d'évaluation.
     */
    public function index(): JsonResponse
    {
        $grilles = GrilleEvaluation::with([
            'session',
            'typeMaster',
        ])->orderBy('nom')->get();

        return response()->json($grilles);
    }

    /**
     * Créer une nouvelle grille d'évaluation.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'required|string|max:50',
            'session_id' => 'required|exists:soutenance_sessions,idSession',
            'type_master_id' => 'required|exists:type_masters,idType',
        ]);

        $grille = GrilleEvaluation::create($validated);

        return response()->json(
            $grille->load(['session', 'typeMaster']),
            201
        );
    }

    /**
     * Afficher une grille d'évaluation précise.
     */
    public function show(GrilleEvaluation $grilleEvaluation): JsonResponse
    {
        return response()->json(
            $grilleEvaluation->load([
                'session',
                'typeMaster',
                'criteres',
            ])
        );
    }

    /**
     * Modifier une grille d'évaluation.
     */
    public function update(
        Request $request,
        GrilleEvaluation $grilleEvaluation
    ): JsonResponse {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'statut' => 'sometimes|required|string|max:50',
            'session_id' => 'sometimes|required|exists:soutenance_sessions,idSession',
            'type_master_id' => 'sometimes|required|exists:type_masters,idType',
        ]);

        $grilleEvaluation->update($validated);

        return response()->json(
            $grilleEvaluation->load([
                'session',
                'typeMaster',
            ])
        );
    }

    /**
     * Supprimer une grille d'évaluation.
     */
    public function destroy(
        GrilleEvaluation $grilleEvaluation
    ): JsonResponse {
        $grilleEvaluation->delete();

        return response()->json([
            'message' => 'Grille d’évaluation supprimée avec succès.'
        ]);
    }
}