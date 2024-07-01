<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table='discounts';
    protected $fillable=[
      'id',
      'discount',
      'price',
      'created_at',
      'updated_at',
    ];

    protected $timestamp=true;

    public function scopeSelection($q){
       return $q->select([
           'id',
           'discount',
           'price',
           'created_at',
           'updated_at',
       ]);
    }
}
