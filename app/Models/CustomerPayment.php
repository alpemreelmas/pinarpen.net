<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    use HasFactory;

    public function getProject()
    {
       return $this->belongsTo(Project::class,"project_id","id");
    }
}
