<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'type',
        'date',
        'amount',
    ];

    public function category() {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
