<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public $table = 'event';

    protected $primaryKey = 'eventid';

    public $incrementing = false;

    protected $fillable = [
        'eventid',
        'eventpicture',
        'eventname',
        'eventdate',
        'eventplace',
        'eventtime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'custid');
    }
}
