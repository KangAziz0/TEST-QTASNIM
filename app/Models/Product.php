<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','stock','price','id_category'];

    public function Category(){
        return $this->belongsTo(Categories::class,'id_category','id');
    }
    public function transaction(){
        return $this->hasMany(transaction::class,'id_product','id');
    }
}
