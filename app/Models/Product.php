<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Product extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'thumbnail',
        'desc',
        'price',
        'currency_id',
        'position'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function category()
    {
        return $this->categories()->limit(1);
    }

    public function currency(){
        return $this->hasOne(Currency::class, 'id','currency_id');
    }

    public function currencyShort(){
        return $this->hasOne(Currency::class, 'id','currency_id')->select('id','name','icon');
    }
}
