<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailWorshipTemplate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function linkActivityTemplate(){
        return $this->hasOne(ActivityTemplate::class,'id','id_activity_template');
    }
}
