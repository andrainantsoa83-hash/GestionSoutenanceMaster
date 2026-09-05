<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bareme extends Model
{
    protected $table = 'baremes';

    protected $primaryKey = 'idBareme';

    protected $fillable = [
        'nom',
        'note_min',
        'note_max',
        'description',
        'critere_id',
    ];

    protected $casts = [
        'note_min' => 'decimal:2',
        'note_max' => 'decimal:2',
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