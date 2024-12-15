<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCust extends Model
{
    use HasFactory;

    public $table = 'ordercust';

    protected $fillable = [
        'id',
        'quantity',
        'orderdate',
        'ordertime',
        'ordermethod',
        'totalbill',
        'menuid',
        'menuname',
    ];
}
