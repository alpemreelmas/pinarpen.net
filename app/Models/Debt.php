<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class,"supplier_id","id");
    }

    public function getProject()
    {
        return $this->belongsTo(Project::class,"project_id","id");

    }
}
