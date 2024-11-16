<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'program_studi',
        'nim',
        'address',
        'city',
        'province',
        'postal_code',
        'attendance_type', 
        'number_of_guests',
        'graduation_type',
        'toga_size',
        'graduation_payment_file',
        'family_payment_file', 
        'status',
        'checked_in',
        'kode_unik',
        'delivery',
        'check_in_date',
    ];
    protected $casts = [
        'check_in_date' => 'datetime',
    ];
}
