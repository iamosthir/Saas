<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    public function generateID()
    {
        $str1 = str_shuffle(hash("sha512",time()."OSTHIR-OP".rand(1,9999999)));
        $str2 = str_shuffle(hash("sha512",rand(420,5899855)."CODING_IS_IN_MY_DNA".time()));

        return Str::limit($str1, 3, '').Str::limit($str2, 3, '');
    }

    public function items()
    {
        return $this->hasMany(OrderProduct::class,"order_id","id")->with(["product","variant"]);
    }

    public function city()
    {
        return $this->belongsTo(City::class,"city_id","id");
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class,"shiping_id","id");
    }

    public function page()
    {
        return $this->belongsTo(Page::class,"page_id","id");
    }
}
