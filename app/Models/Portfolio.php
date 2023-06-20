<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'description',
    ];

    public function getGallery()
    {
        return $this->hasMany(Gallery::class,"portfolios_id","id");
    }
}
