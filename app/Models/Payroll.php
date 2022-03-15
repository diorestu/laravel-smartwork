<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded =['id_pay'];
    protected $primaryKey = 'id_pay';

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}

