<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
    protected $table = 'soutenance_sessions';

    protected $primaryKey = 'idSession';

    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'statut',
    ];

    public function grillesEvaluation(): HasMany
    {
        return $this->hasMany(
            GrilleEvaluation::class,
            'session_id',
            'idSession'
        );
    }
}