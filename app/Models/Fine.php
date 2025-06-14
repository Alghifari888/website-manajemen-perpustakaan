<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrowing_id',
        'user_id',
        'amount',
        'reason',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
        ];
    }

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class);
    }

    /**
     * TAMBAHKAN FUNGSI INI
     * Mendefinisikan relasi bahwa setiap denda (Fine)
     * "milik" satu Pengguna (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}