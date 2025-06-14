<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // Tentukan primary key karena bukan 'id'
    protected $primaryKey = 'user_id';

    // Non-incrementing karena primary key adalah foreign key
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nis_nim',
        'address',
        'phone_number',
        'profile_photo_path'
    ];

    // Definisikan relasi sebaliknya ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}