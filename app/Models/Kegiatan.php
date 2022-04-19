<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kgt';
    protected $guarded = ['id_kgt'];
    public $timestamps = false;
    /**
     * Get all of the comments for the Kegiatan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery(): HasMany
    {
        return $this->hasMany(KegiatanGallery::class, 'id_kegiatan', 'id_kgt');
    }
}
