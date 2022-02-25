<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lembur extends Model
{
    use HasFactory;
    protected $table        = "lemburs";
    protected $primaryKey   = "id";
    protected $guarded      = ["id"];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
