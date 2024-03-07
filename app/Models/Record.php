<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

class Record extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'location',
        'age_group_id',
        'product_category_id',
        'branch_id',
        'remarks'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function age_group(){
        return $this->belongsTo(AgeGroup::class);
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
