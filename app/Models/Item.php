<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'description',
        'column_id',
    ];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }
}
