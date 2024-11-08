<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalRent extends Model
{
    use HasFactory;
    protected $table='additional_rents';
    protected $fillable=[
        'id',
        'name',
        'created_at',
        'updated_at',
    ];
    protected $timestamp=true;

    public function scopeSelection($q){
        return $q->select([
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);
    }
}
