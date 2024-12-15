<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'custid');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menuid');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'ordercustid');
    }
}
