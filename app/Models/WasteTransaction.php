<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WasteTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function liquid()
    {
        return $this->belongsTo(Liquid::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
