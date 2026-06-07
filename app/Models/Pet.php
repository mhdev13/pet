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
        'gender',
        'is_active',
        'instagram',
        'facebook',
        'tiktok',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'age'       => 'integer',
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
