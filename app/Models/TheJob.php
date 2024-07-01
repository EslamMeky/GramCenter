<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheJob extends Model
{
    use HasFactory;
    protected $table='the_jobs';
    protected  $fillable=[
      'id',
      'name',
      'price',
      'created_at',
      'updated_at'
    ];
    public $timestamps=true;

    public function scopeSelection($q)
    {
        $q->select([
            'id',
            'name',
            'price',
            'created_at',
            'updated_at'
        ]);
    }
}
