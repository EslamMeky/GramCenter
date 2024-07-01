<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table='employees';
    protected $fillable=[
        'id',
        'employee_name',
        'phone',
        'salary',
        'num',
        'created_at',
        'updated_at',
    ];

    protected $timestamp=true;

    public function ScopeSelection($q)
    {
        return $q->select([
            'id',
            'employee_name',
            'phone',
            'salary',
            'num',
            'created_at',
            'updated_at',
        ]);
    }
}
