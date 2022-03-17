<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AktivitasImage extends Model
{
    use HasFactory;
    protected $guarded      = ['id'];
    protected $table        = 'aktivitas_images';
    protected $primaryKey   = 'id';

    public function aktivitas(): HasOne
    {
        return $this->hasOne(Aktivitas::class, 'id', 'aktivitas_id');
    }
}
