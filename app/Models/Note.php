<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    // Bagitahu model field mana yang boleh kita isi guna updateOrCreate
    protected $fillable = [
        'user_id', 
        'content'
    ];

    // Relationship: Setiap nota kepunyaan seorang user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}