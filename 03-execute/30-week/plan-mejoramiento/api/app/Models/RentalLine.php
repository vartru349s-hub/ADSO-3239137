<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalLine extends Model
{
    use HasUuids;

    protected $fillable = ['rental_id', 'bicycle_id', 'model_code', 'bicycle_name', 'category_name', 'hourly_rate', 'due_at', 'returned_at'];

    protected function casts(): array
    {
        return ['hourly_rate' => 'decimal:2', 'due_at' => 'datetime', 'returned_at' => 'datetime'];
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    public function bicycle(): BelongsTo
    {
        return $this->belongsTo(Bicycle::class)->withTrashed();
    }
}
