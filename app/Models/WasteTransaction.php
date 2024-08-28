<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class WasteTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getApprovedAtAttribute(): string
    {
        $locale = App::getLocale();
        return Carbon::parse($this->attributes['approved_at'])->locale($locale)
            ->translatedFormat('d F Y H:i');
    }

    public function detail(): BelongsTo
    {
        return $this->belongsTo(WasteTransactionDetail::class, 'waste_transaction_detail_id');
    }
}
