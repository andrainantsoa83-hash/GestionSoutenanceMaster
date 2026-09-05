<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TypeMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TypeMasterController extends Controller
{
    /**
     * Afficher tous les types de Master.
     */
    public function index(): JsonResponse
    {
        $types = TypeMaster::orderBy('nom')->get();

        return response()->json($types);
    }

    /**
     * Créer un nouveau type de Master.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $typeMaster = TypeMaster::create($validated);

        return response()->json($typeMaster, 201);
    }

    /**
     * Afficher un type de Master précis.
     */
    public function show(TypeMaster $typeMaster): JsonResponse
    {
        return response()->json($typeMaster);
    }

    /**
     * Modifier un type de Master.
     */
    public function update(
        Request $request,
        TypeMaster $typeMaster
    ): JsonResponse {
        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
        ]);

        $typeMaster->update($validated);

        return response()->json($typeMaster);
    }

    /**
     * Supprimer un type de Master.
     */
    public function destroy(TypeMaster $typeMaster): JsonResponse
    {
        $typeMaster->delete();

        return response()->json([
            'message' => 'Type de Master supprimé avec succès.'
        ]);
    }
}