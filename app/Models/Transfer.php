<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transfer extends Model
{
  use HasFactory;

  protected $fillable = [
    'status', // requested | reserved | borrowed | expired | returned
    'book_id',
    'user_id',
    'expiration',
    'renewals',
    'finished',
    'rf_id',
    'token',
    'returned_at'
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

  public function Expiration(){
    if(!$this->expiration) return null;
    return Carbon::parse($this->expiration);
  }
  public function getExpiration(){
    if(!$this->expiration) return '';

    $carbonDate = $this->Expiration();
    return $carbonDate->format('d/m/Y H:i');
  }
}
