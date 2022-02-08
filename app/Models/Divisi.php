<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    protected $guarded      = ['div_id'];
    protected $table        = 'divisis';
    protected $primaryKey   = 'div_id';
}
