<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  use HasFactory;

  protected $fillable = [
    'is_favorited',
    'like', // -1 | 0 | 1
    'feedback',
    'has_interest',
    'user_id',
    'book_id',
  ];
}
