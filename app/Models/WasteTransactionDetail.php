<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteTransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getPhotoAttribute(): string
    {
        return $this->attributes['photo'] ? asset('storage/' . $this->attributes['photo']) : '';
    }

    public function getDocumentAttribute(): string
    {
        return $this->attributes['document'] ? asset('storage/' . $this->attributes['document']) : '';
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function liquidWaste(): BelongsTo
    {
        return $this->belongsTo(LiquidWaste::class, 'liquid_waste_id');
    }
}
