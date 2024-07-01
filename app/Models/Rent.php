<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $table='rents';
    protected $fillable=[
        'id',
        'name',
        'category',
        'type_insurance',
        'insurance',
        'status' ,
        'created_at',
        'updated_at',
    ];
    public $timestamps=true;

    public function scopeSelection($q){
      return  $q->select([
            'id',
            'name',
            'category',
            'type_insurance',
            'insurance',
            'status' ,
            'created_at',
            'updated_at',
        ]);
    }

}
