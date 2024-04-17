<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
  use HasFactory;

  protected $fillable = [
    'status', // reserved | borrowed | expired
    'book_id',
    'user_id',
    'expiration',
    'renewals',
    'finished',
    'rf_id'
  ];

  public function book(){
    return $this->belongsTo(Book::class, 'book_id');
  }
}
