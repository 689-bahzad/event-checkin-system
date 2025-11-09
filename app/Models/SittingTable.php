<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SittingTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function registrations()
    {
        return $this->belongsToMany(Registration::class, 'registration_sitting_tables')
                    ->withTimestamps();
    }
}
