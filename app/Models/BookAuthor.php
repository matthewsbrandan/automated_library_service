<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
  use HasFactory;
  public $timestamps = false;
  protected $fillable = [
    'book_id', 'author_id'
  ];
}
