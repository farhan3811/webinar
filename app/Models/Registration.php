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
        'toga_size',
        'file_path',
        'status',
        'checked_in',
    ];
}
