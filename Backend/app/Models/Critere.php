<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Critere extends Model
{
    protected $table = 'criteres';

    protected $primaryKey = 'idCritere';

    protected $fillable = [
        'libelle',
        'description',
        'actif',
        'grille_evaluation_id',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function grilleEvaluation(): BelongsTo
    {
        return $this->belongsTo(
            GrilleEvaluation::class,
            'grille_evaluation_id',
            'idGrille'
        );
    }

    public function bareme(): HasOne
    {
        return $this->hasOne(
            Bareme::class,
            'critere_id',
            'idCritere'
        );
    }

    public function coefficient(): HasOne
    {
        return $this->hasOne(
            Coefficient::class,
            'critere_id',
            'idCritere'
        );
    }
}