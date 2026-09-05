<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GrilleEvaluation extends Model
{
    protected $table = 'grille_evaluations';

    protected $primaryKey = 'idGrille';

    protected $fillable = [
        'nom',
        'description',
        'statut',
        'session_id',
        'type_master_id',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(
            Session::class,
            'session_id',
            'idSession'
        );
    }

    public function typeMaster(): BelongsTo
    {
        return $this->belongsTo(
            TypeMaster::class,
            'type_master_id',
            'idType'
        );
    }

    public function criteres(): HasMany
    {
        return $this->hasMany(
            Critere::class,
            'grille_evaluation_id',
            'idGrille'
        );
    }
}