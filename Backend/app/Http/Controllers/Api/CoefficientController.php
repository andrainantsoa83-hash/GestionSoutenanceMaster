<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coefficient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoefficientController extends Controller
{
    /**
     * Afficher tous les coefficients.
     */
    public function index(): JsonResponse
    {
        $coefficients = Coefficient::with('critere')
            ->orderBy('valeur')
            ->get();

        return response()->json($coefficients);
    }

    /**
     * Créer un nouveau coefficient.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'valeur' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'critere_id' => 'required|exists:criteres,idCritere|unique:coefficients,critere_id',
        ]);

        $coefficient = Coefficient::create($validated);

        return response()->json(
            $coefficient->load('critere'),
            201
        );
    }

    /**
     * Afficher un coefficient précis.
     */
    public function show(Coefficient $coefficient): JsonResponse
    {
        return response()->json(
            $coefficient->load('critere')
        );
    }

    /**
     * Modifier un coefficient.
     */
    public function update(
        Request $request,
        Coefficient $coefficient
    ): JsonResponse {
        $validated = $request->validate([
            'valeur' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|nullable|string',
            'critere_id' => 'sometimes|required|exists:criteres,idCritere|unique:coefficients,critere_id,' . $coefficient->idCoeff . ',idCoeff',
        ]);

        $coefficient->update($validated);

        return response()->json(
            $coefficient->load('critere')
        );
    }

    /**
     * Supprimer un coefficient.
     */
    public function destroy(Coefficient $coefficient): JsonResponse
    {
        $coefficient->delete();

        return response()->json([
            'message' => 'Coefficient supprimé avec succès.'
        ]);
    }
}