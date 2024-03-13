<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table='users';
    protected $fillable = [
        'name',
        'email',
    ];

    public $timestamps=true;

    public function scopeSelection($q)
    {
        return $q->select([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ]);
    }
}
