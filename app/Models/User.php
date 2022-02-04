<?php

namespace App\Models;

use App\Models\Cabang;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Sertifikasi;
use App\Models\StatusKawin;
use App\Models\MasaKerja;
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

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_divisi', 'div_id');
    }

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'jabatan_id');
    }

    public function sertifikasi(): BelongsTo
    {
        return $this->belongsTo(Sertifikasi::class, 'id_sertifikasi', 'id');
    }

    public function status_kawin(): BelongsTo
    {
        return $this->belongsTo(StatusKawin::class, 'tanggungan', 'id');
    }

    public function masa_kerja(): BelongsTo
    {
        return $this->belongsTo(MasaKerja::class, 'id_masaKerja', 'id');
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
