<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiJenis extends Model
{
    use HasFactory;
    protected $primaryKey  = 'id';
    protected $guarded     = ['id'];
    protected $table       = 'cuti_jenis';
}
