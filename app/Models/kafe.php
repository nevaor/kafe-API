<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Kafe extends Model
{
    use SoftDeletes;
    protected $table = 'kafes';
    protected $fillable = [
        'nama',
        'pesanan',
        'level',
        'jumlah',
        'tanggal_pembelian',
    ];
    // public $timestamps = false;
}