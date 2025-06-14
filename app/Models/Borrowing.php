<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'status',
        'processed_by_user_id',
    ];

    // Casting untuk memastikan tipe data benar
    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Relasi ke User (Peminjam)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Buku
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    // Relasi ke User (Petugas yang memproses)
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by_user_id');
    }

    // Relasi ke Denda
    public function fine()
    {
        return $this->hasOne(Fine::class);
    }
}
