<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMenu extends Model
{
    use HasFactory;

    public $table = 'ordermenu';

    protected $fillable = [
        'quantity',
        'orderdate',
        'ordertime',
        'ordermethod',
        'totalbill',
        'menuid',
        'menuname',
    ];
}
