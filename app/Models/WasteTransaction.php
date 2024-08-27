<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function liquid(): BelongsTo
    {
        return $this->belongsTo(LiquidWaste::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function detail(): BelongsTo
    {
        return $this->belongsTo(WasteTransactionDetail::class, 'waste_transaction_detail_id');
    }
}
