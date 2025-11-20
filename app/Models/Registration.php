<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'count',
        'lucky_number',
        'status',
        'type',
        'department',
        'id_number',
        'gender',
        'qr_status',
        'qr_code_path',
        'is_check_out',
        'is_email_sent',
        'can_redeem_drinks',
        'drinks_redeemed'
    ];

    public function sittingTable()
    {
        return $this->belongsToMany(SittingTable::class, 'registration_sitting_tables')
                    ->withTimestamps();
    }
}
