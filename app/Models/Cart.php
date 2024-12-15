<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'cartid',
        'quantity',
        'totalprice',
        'userid',
        'menuitemid',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestOrder = self::latest('cartid')->first();
            if ($latestOrder) {
                $lastNumber = (int)substr($latestOrder->cartid, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }
            $model->cartid = date('Ymd') . $newNumber;
        });
    }
}
