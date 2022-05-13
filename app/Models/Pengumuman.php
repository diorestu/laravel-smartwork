<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = "pengumuman";
    protected $primaryKey = "id";

    public function divisi(): HasOne
    {
        return $this->hasOne(Divisi::class, 'div_id', 'id_divisi');
    }
}
