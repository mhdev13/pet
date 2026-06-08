<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'type',
        'breed',
        'age',
        'weight',
        'gender',
        'is_active',
        'instagram',
        'facebook',
        'tiktok',
        'flea_medicine_date',
        'deworming_date',
    ];

    protected function casts(): array
    {
        return [
            'is_active'          => 'boolean',
            'age'                => 'integer',
            'weight'             => 'float',
            'flea_medicine_date' => 'date',
            'deworming_date'     => 'date',
        ];
    }

    public static array $types = [
        'Anjing', 'Kucing', 'Burung', 'Kelinci', 'Hamster', 'Ikan', 'Reptil', 'Lainnya',
    ];

    public function vaccines(): HasMany
    {
        return $this->hasMany(Vaccine::class)->orderBy('vaccine_date', 'desc');
    }
}
