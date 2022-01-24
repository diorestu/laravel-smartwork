<?php

namespace App\Models;

use App\Models\Cabang;
use App\Models\Absensi;
use App\Models\UserConfig;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class, 'id_cabang', 'id');
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'id', 'id_user');
    }

    public function config(): HasOne
    {
        return $this->hasOne(UserConfig::class, 'id_admin', 'id');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }



}
