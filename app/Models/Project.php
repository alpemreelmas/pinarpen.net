<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function getCustomer()
    {
        return $this->belongsTo(Customer::class,"customer_id","id");
    }

    public function getSupplier()
    {
        return $this->belongsTo(Supplier::class,"supplier_id","id");
    }

    public function getPaymentHistory()
    {
        return $this->hasMany(CustomerPayment::class,"project_id","id");
    }

    public function getDebt()
    {
        return $this->hasOne(Debt::class,"project_id","id");
    }
}
