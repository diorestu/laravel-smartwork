<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Aktivitas extends Model
{
    use HasFactory;
    protected $table        = "aktivitas";
    protected $guarded      = ['id'];
    protected $primaryKey   = "id";

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
