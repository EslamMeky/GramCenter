<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class advantageLand extends Model
{
    use HasFactory;
    protected $table='advantage_lands';

    protected $fillable=[
        'id',
        'name',
        'desc',
        'photo',
        'created_at',
        'updated_at',
    ];
    protected $timestamp=true;

    public function scopeSelection($q){
        return $q->select([
            'id',
            'name',
            'desc',
            'photo',
            'created_at',
            'updated_at',
        ]);
    }
    public function getPhotoAttribute($val)
    {
        return ($val!=null)? asset('assets/'.$val):"";
    }
}
