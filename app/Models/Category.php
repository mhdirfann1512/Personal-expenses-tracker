<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Benarkan data masuk ke column ni
    protected $fillable = ['user_id', 'name', 'icon', 'color'];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}