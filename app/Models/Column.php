<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = [
        'name', 
        'position',
        'board_id' 
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
