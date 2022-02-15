<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserShift extends Model
{
    use HasFactory;
    protected $guarded  = ['id'];
    protected $table    = 'user_shifts';
    public $timestamps  = false;

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'id_user_shift', 'id');
    }
}
