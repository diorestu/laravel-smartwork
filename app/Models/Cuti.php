<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuti extends Model
{
    use HasFactory;
    protected $primaryKey  = 'id_cuti';
    protected $guarded     = ['id_cuti'];
    protected $table       = 'cutis';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function cutiJenis(): BelongsTo
    {
        return $this->belongsTo(CutiJenis::class, 'id_cuti_jenis', 'id');
    }
}
