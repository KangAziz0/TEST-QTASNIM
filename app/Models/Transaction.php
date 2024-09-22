<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable =['date_transaction','id_product','sold','category'];
    

    public function products(){
        return $this->belongsTo(Product::class,'id_product','id');
    }
}
