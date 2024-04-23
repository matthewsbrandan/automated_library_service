<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
  use HasFactory;

  protected $fillable = [
    'status', // requested | reserved | borrowed | expired
    'book_id',
    'user_id',
    'expiration',
    'renewals',
    'finished',
    'rf_id'
  ];
  protected $dates = ['created_at','updated_at', 'expiration'];

  public function book(){
    return $this->belongsTo(Book::class, 'book_id');
  }
  public function user(){
    return $this->belongsTo(User::class, 'user_id');
  }
}
