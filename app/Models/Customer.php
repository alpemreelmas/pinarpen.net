<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'surname',
      'phone_number',
      'address'
    ];

    public function getProjects()
    {
        return $this->hasMany(Project::class,"customer_id","id");
    }

    public function getPaymentHistory()
    {
        return $this->hasManyThrough(CustomerPayment::class,Project::class, 'customer_id','project_id','id','id');
    }

    public function getAllDebts()
    {
        return $this->getProjects()->sum("cost");
    }

    public function getPaidDebts()
    {
        return $this->getProjects()->sum("paid_payment");
    }

    public function getFullNameAttribute()
    {
        return $this->name." ".$this->surname;
    }

}
