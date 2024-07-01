<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table='sub_categories';
    protected $fillable=[
      'id',
      'category_id',
      'item',
      'price',
      'created_at',
      'updated_at'
    ];
    protected $timestamp=true;

    public function scopeSelection($q){
        return $q->select([
            'id',
            'category_id',
            'item',
            'price',
            'created_at',
            'updated_at'
        ]);
    }

    public function category()
    {
      return $this->belongsTo(Category::class,'category_id','id');
    }
}
