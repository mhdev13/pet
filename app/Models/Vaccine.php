<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccine extends Model
{
    protected $fillable = [
        'pet_id',
        'vaccine_name',
        'vaccine_date',
        'next_vaccine_date',
        'administered_by',
        'clinic',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'vaccine_date'      => 'date',
            'next_vaccine_date' => 'date',
        ];
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }
}
