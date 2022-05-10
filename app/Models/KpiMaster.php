<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KpiMaster extends Model
{
    use HasFactory;
    protected $table        = "kpi_master";
    protected $primaryKey   = "id";
    protected $guarded      = ["id"];
}
