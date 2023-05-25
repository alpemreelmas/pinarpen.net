<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
      "project_id",
      "payer",
      "amount"
    ];

    protected $casts = [
      "amount"=>"integer"
    ];

    public function getProject()
    {
       return $this->belongsTo(Project::class,"project_id","id");
    }
}
