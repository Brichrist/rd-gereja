<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityTemplate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function linkParameterActivityTemplate(){
        return $this->hasMany(ParameterActivityTemplate::class,'id_activity_template','id');
    }
    
}
