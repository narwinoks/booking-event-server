<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'events';

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
