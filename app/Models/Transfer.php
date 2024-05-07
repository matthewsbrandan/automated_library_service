<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
    'rf_id',
    'token'
  ];

  public function book(){
    return $this->belongsTo(Book::class, 'book_id');
  }
  public function user(){
    return $this->belongsTo(User::class, 'user_id');
  }
  public function bookStock(){
    return $this->hasOne(BookStock::class, 'transfer_id');
  }

  public function getExpiration(){
    if(!$this->expiration) return '';

    $carbonDate = Carbon::parse($this->expiration);
    return $carbonDate->format('d/m/Y H:i');
  }
}
