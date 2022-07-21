<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensis';
    public $timestamps = false;
    protected $guarded = ['id'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function user_shift(): HasOne
    {
        return $this->hasOne(UserShift::class, 'id_shift', 'usershift_id');
    }
}
