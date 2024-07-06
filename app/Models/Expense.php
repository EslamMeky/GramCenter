<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $table='expenses';
    protected $fillable=[
        'id',
        'side',
        'reason',
        'price',
        'created_at',
        'updated_at',
    ];

    public $timestamps=true;

    public function scopeSelection($q){
        return $q->select([
            'id',
            'side',
            'reason',
            'price',
            'created_at',
            'updated_at',
        ]);
    }
}
