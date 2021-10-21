<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table_id',
        'product_id',
        'user_id',
        'count'
    ];

    public function table()
    {
        return $this->belongsTo(Table::class,'table_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function productShort()
    {
        return $this->belongsTo(Product::class,'product_id','id')->select('id','title','thumbnail','price','currency_id');
    }
}
