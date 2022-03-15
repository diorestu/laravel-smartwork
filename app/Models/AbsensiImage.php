<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class AbsensiImage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function absensi(): HasOne
    {
        return $this->hasOne(Absensi::class, 'id', 'absensi_id');
    }
}
