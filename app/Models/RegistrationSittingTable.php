<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationSittingTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'sitting_table_id',
    ];

}
