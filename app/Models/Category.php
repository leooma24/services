<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'color',
        'icon',
        'user_id'
    ];

    public function movements() {
        return $this->hasMany(Movement::class, 'category_id', 'id');
    }
}
