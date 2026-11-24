<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi
    protected $fillable = [
        'name',
        'type',
        'price_per_hour',
        'description',
        'image',
    ];

    // Relasi: Satu lapangan dapat memiliki banyak detail transaksi (hasMany)
    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class);
    }

    /**
     * URL gambar arena (foto unggahan admin atau foto default berdasarkan tipe arena).
     */
    public function getDisplayImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return match ($this->type) {
            'Panoramic' => asset('images/court-panoramic.svg'),
            'Indoor'    => asset('images/court-indoor.svg'),
            'Outdoor'   => asset('images/court-outdoor.svg'),
            default     => asset('images/hero-padel.svg'),
        };
    }
}
