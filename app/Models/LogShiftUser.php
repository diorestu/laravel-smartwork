<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LogShiftUser extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'id_shift_lama', 'id');
    }
    public function shift_baru(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'id_shift_baru', 'id');
    }
}
