<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        "supplier_id",
        "material_type",
        "unit_price_of_material",
        "square_meters",
        "material_amount",
        "unit_price_of_material"
    ];

    protected $casts = [
        "unit_price_of_material"=>"float",
        "square_meters"=>"float",
        "material_amount"=>"integer"
    ];

    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class,"supplier_id","id");
    }

    public function getProject()
    {
        return $this->belongsTo(Project::class,"project_id","id");

    }
}
