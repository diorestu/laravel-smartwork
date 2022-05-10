<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded =['id_pay'];
    protected $primaryKey = 'id_pay';

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    /**
     * Get the slip that owns the Payroll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function slip(): BelongsTo
    {
        return $this->belongsTo(PayrollParent::class, 'id_payroll', 'id');
    }
}

