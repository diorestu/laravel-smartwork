<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AbsensiImage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'absensi_images';
    protected $primaryKey = 'id';

    public function absensi(): HasOne
    {
        return $this->hasOne(Absensi::class, 'id', 'absensi_id');
    }
}
