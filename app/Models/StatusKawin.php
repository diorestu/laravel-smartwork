<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusKawin extends Model
{
    use HasFactory;
    protected $table        = 'status_kawins';
    protected $guarded      = ['id'];
    protected $primaryKey   = 'id';
}
