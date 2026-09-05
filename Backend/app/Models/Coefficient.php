<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coefficient extends Model
{
    protected $table = 'coefficients';

    protected $primaryKey = 'idCoeff';

    protected $fillable = [
        'valeur',
        'description',
        'critere_id',
    ];

    protected $casts = [
        'valeur' => 'decimal:2',
    ];

    public function critere(): BelongsTo
    {
        return $this->belongsTo(
            Critere::class,
            'critere_id',
            'idCritere'
        );
    }
}