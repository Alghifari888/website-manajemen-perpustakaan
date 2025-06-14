<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'title', 'author', 'publisher', 'publication_year',
        'isbn', 'stock_quantity', 'available_quantity', 'cover_image_path',
        'description', 'slug',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // Model Event untuk otomatisasi
    protected static function boot()
    {
        parent::boot();
        // Saat buku baru dibuat
        static::creating(function ($book) {
            // Buat slug unik dari kombinasi judul dan ISBN
            $book->slug = Str::slug($book->title . '-' . $book->isbn);
            // Inisialisasi stok yang tersedia sama dengan total stok
            $book->available_quantity = $book->stock_quantity;
        });
    }
}