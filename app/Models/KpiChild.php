<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class KpiChild extends Model
{
    use HasFactory;
    protected $table        = "kpi_child";
    protected $primaryKey   = "id";
    protected $guarded      = ["id"];

    public function kpi_master(): HasOne
    {
        return $this->hasOne(KpiMaster::class, 'id', 'id_kpi_master');
    }
}
