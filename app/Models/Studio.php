<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;
    protected $table='studios';
    protected $fillable=[
        'id',
        'category_id',
        'notes',
        'addService',
        'priceService',
        'dateService',
        'name',
        'phone',
        'address',
        'appropriate',
        'receivedDate',
        'pay',
        'rest',
        'total',
        'DateOfTheFirstInstallment',
        'secondInstallment',
        'DateOfTheSecondInstallment',
        'thirdInstallment',
        'DateOfTheThirdInstallment',
        'reason_discount_id',
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
            'dateService',
            'name',
            'phone',
            'address',
            'appropriate',
            'receivedDate',
            'pay',
            'rest',
            'total',
            'DateOfTheFirstInstallment',
            'secondInstallment',
            'DateOfTheSecondInstallment',
            'thirdInstallment',
            'DateOfTheThirdInstallment',
            'reason_discount_id',
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

    public function discount(){
        return $this->belongsTo(Discount::class,'reason_discount_id','id');
    }
}
