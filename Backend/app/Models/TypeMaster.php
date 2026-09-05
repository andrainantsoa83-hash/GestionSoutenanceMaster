<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TypeMaster extends Model
{
    protected $table = 'type_masters';

    protected $primaryKey = 'idType';

    protected $fillable = [
        'nom',
        'description',
    ];

    public function grillesEvaluation(): HasMany
    {
        return $this->hasMany(
            GrilleEvaluation::class,
            'type_master_id',
            'idType'
        );
    }
}