<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devolucione extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_cobrado',
        'adicional_cobrado',
        'fecha',
        'prestamo_id',
        'user_id',
        'bicicleta_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_cobrado' => 'decimal:2',
            'adicional_cobrado' => 'decimal:2',
            'fecha' => 'datetime',
        ];
    }

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bicicleta(): BelongsTo
    {
        return $this->belongsTo(Bicicleta::class, 'bicicleta_id', 'i');
    }
}
