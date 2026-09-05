<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bareme;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaremeController extends Controller
{
    /**
     * Afficher tous les barèmes.
     */
    public function index(): JsonResponse
    {
        $baremes = Bareme::with('critere')
            ->orderBy('nom')
            ->get();

        return response()->json($baremes);
    }

    /**
     * Créer un nouveau barème.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'note_min' => 'required|numeric|min:0',
            'note_max' => 'required|numeric|gte:note_min',
            'description' => 'nullable|string',
            'critere_id' => 'required|exists:criteres,idCritere|unique:baremes,critere_id',
        ]);

        $bareme = Bareme::create($validated);

        return response()->json(
            $bareme->load('critere'),
            201
        );
    }

    /**
     * Afficher un barème précis.
     */
    public function show(Bareme $bareme): JsonResponse
    {
        return response()->json(
            $bareme->load('critere')
        );
    }

    /**
     * Modifier un barème.
     */
    public function update(
        Request $request,
        Bareme $bareme
    ): JsonResponse {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'note_min' => 'sometimes|required|numeric|min:0',
            'note_max' => 'sometimes|required|numeric|gte:note_min',
            'description' => 'sometimes|nullable|string',
            'critere_id' => 'sometimes|required|exists:criteres,idCritere|unique:baremes,critere_id,' . $bareme->idBareme . ',idBareme',
        ]);

        $bareme->update($validated);

        return response()->json(
            $bareme->load('critere')
        );
    }

    /**
     * Supprimer un barème.
     */
    public function destroy(Bareme $bareme): JsonResponse
    {
        $bareme->delete();

        return response()->json([
            'message' => 'Barème supprimé avec succès.'
        ]);
    }
}