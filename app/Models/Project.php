<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
      "customer_id",
      "supplier_id",
      "material_type",
      "material_amount",
      "payment_type",
      "unit_price_of_material",
      "square_meters",
      "earning",
      "note",
      "cost",
      "pending_payment",
      "paid_payment",
      "pay_date",
    ];

    protected $casts = [
      "material_amount"=>"integer",
      "earning"=>"integer",
      "unit_price_of_material"=>"float",
      "square_meters"=>"float",
    ];


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
