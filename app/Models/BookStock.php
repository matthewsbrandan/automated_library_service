<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStock extends Model
{
  use HasFactory;

  protected $fillable = [
    'rf_id',
    'book_id',
    'transfer_id',
    'status' // 'reserved', 'borrowed', 'available'
  ];

  public function book(){
    return $this->belongsTo(Book::class, 'book_id');
  }
}
