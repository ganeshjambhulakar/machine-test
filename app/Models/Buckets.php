<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buckets extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'volume'];
    // public $timestamps = false;

    public function Test(){
        return $this->hasMany('App\Models\Test','balls_id');
    }
}
