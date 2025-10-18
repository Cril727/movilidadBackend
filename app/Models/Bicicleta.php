<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bicicleta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'marca',
        'color',
        'estado',
        'precioAlquiler',
        'regional_id',
    ];

    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regionale::class);
    }
}
