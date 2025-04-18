<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory; protected $table='loans';
    protected $fillable=[
        'id',
        'employee_name',
        'reason',
        'price',
        'created_at',
        'updated_at',
    ];

    public $timestamps=true;

    public function scopeSelection($q){
        return $q->select([
            'id',
            'employee_name',
            'reason',
            'price',
            'created_at',
            'updated_at',
        ]);
    }
}
