<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $fillable = ['buckets_id', 'balls_id','numbers_of_ball'];
    // public $timestamps = false;
    public function Balls(){
        return $this->belongsTo('App\Models\Balls','buckets_id');
    }
    public function Buckets(){
        return $this->belongsTo('App\Models\Buckets','balls_id');
    }
}
