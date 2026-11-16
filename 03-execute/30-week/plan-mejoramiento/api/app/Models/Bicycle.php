<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bicycle extends Model
{
    use HasUuids,SoftDeletes;

    protected $fillable = ['model_code', 'name', 'category_id', 'hourly_rate', 'total_units', 'available_units'];

    protected function casts(): array
    {
        return ['hourly_rate' => 'decimal:2', 'total_units' => 'integer', 'available_units' => 'integer'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rentalLines(): HasMany
    {
        return $this->hasMany(RentalLine::class);
    }
}
