<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class reservations extends Model
{
    protected $table = 'reservations';
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'total_person',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(rooms::class, 'room_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room_type()
    {
        return $this->belongsTo(room_type::class,'room_type_id');
    }

    public function getTotalPriceAttribute()
    {
        $checkin = Carbon::parse($this->check_in);
        $checkout = Carbon::parse($this->check_out);
        $days = $checkin->diffInDays($checkout);

        $price = $this->room->room_type->price;
        return $days * $price;
    }
}
