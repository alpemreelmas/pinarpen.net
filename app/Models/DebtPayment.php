<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtPayment extends Model
{
    use HasFactory;

    public function getSupplier()
    {
        return $this->belongsTo(Debt::class,"debt_id","id");
    }
}
