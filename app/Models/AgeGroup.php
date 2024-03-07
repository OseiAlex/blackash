<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class AgeGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title'
    ];

    public function record(){
        return $this->hasMany(Record::class);
    }
}
