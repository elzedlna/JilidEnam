<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $table = 'menu';

    protected $primaryKey = 'menuid';

    public $incrementing = false;

    protected $fillable = [
        'menuid',
        'menupicture',
        'menuname',
        'menudesc',
        'menuprice',
        'catid',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'catid', 'catid');
    }

    public function cartItems()
    {
    return $this->hasMany(Cart::class);
    }
}
