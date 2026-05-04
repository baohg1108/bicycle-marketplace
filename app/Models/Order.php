<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $casts = [
        "billing_info"  => "array",
        "shipping_info" => "array",
    ];
}
