<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lowongan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Get all of the rekrutmen for the Lowongan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rekrutmen(): HasMany
    {
        return $this->hasMany(Rekrutmen::class, 'id_lowongan', 'id');
    }
}
