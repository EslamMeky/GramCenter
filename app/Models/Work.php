<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;
    protected $table='works';
    protected $fillable=[
      'id',
      'employee_name_id',
      'job',
      'total',
      'created_at',
      'updated_at'
    ];
    public $timestamps =true;
    public function scopeSelection($q){
        return $q->select([
            'id',
            'employee_name_id',
            'job',
            'total',
            'created_at',
            'updated_at'
        ]);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class,'employee_name_id','id');
    }

//    public function job()
//    {
//        return $this->belongsTo(TheJob::class,'job_id','id');
//    }

}
