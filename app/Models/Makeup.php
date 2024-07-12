<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makeup extends Model
{
    use HasFactory;
    protected $table='makeups';
    protected $fillable=[
      'id',
      'category_id',
      'notes',
      'addService',
      'priceService',
      'name',
      'phone',
      'address',
      'appropriate',
      'pay',
      'rest',
      'total',
      'reason_discount',
      'price',
      'enter',
      'exit',
      'status',
      'arrive',
      'created_at',
      'updated_at',
    ];

    public $timestamps=true;

    public function scopeSelection($q)
    {
     return $q->select([
         'id',
         'category_id',
         'notes',
         'addService',
         'priceService',
         'name',
         'phone',
         'address',
         'appropriate',
         'pay',
         'rest',
         'total',
         'reason_discount',
         'price',
         'enter',
         'exit',
         'status',
         'arrive',
         'created_at',
         'updated_at',
     ])  ;
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
