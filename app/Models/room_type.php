<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room_type extends Model
{
    use HasFactory;

    protected $table = 'room_types';
    protected $fillable = ['tipe_kamar', 'description','price','image'];

    public function rooms(){
        return $this->hasMany(rooms::class, 'room_type_id');
    }
}

