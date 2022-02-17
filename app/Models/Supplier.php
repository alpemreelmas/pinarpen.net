<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function getDebts(){
        return $this->hasMany(Debt::class,"supplier_id","id");
    }

    public function getPayments(){
        return $this->hasManyThrough(DebtPayment::class,Debt::class,"supplier_id","debt_id");
    }

}
