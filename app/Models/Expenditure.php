<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenditure extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "amount",
        "detail"
    ];

    protected $casts = [
        "amount"=>"float"
    ];

}
