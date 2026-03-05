<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['user_id', 'category_id', 'title', 'amount', 'description', 'attachment', 'spent_at'];

    // Cast spent_at jadi date supaya senang guna kat Blade/Flutter
    protected $casts = [
        'spent_at' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}