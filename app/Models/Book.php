<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
  use HasFactory;
  protected $fillable = [
    'isbn', // https://www.googleapis.com/books/v1/volumes?q=isbn:<isbn-aqui>
    'title', // items[0].volumeInfo.title
    'subtitle', // items[0].volumeInfo.subtitle
    // 'authors' // items[0].volumeInfo.authors
    'published_date', // items[0].volumeInfo.publishedDate
    'description', // items[0].volumeInfo.description
    // 'categories' // items[0].volumeInfo.categories
    'image', // items[0].volumeInfo.imageLinks.thumbnail
    'stock',
    'available',
    'reserved',
    'borrowed'
  ];

  public function authors(){
    return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
  }

  public function getAuthorNames(){
    if(isset($this->authors)) return $this->authors->map(function($author){ return $author->name; });
    return [];
  }
  public function getStockResume(){
    return [
      (object)['name' => 'Disponível', 'amount' => $this->available,'percent' => ($this->available * 100) / $this->stock, 'theme' => 'success'],
      (object)['name' => 'Reservados', 'amount' => $this->reserved, 'percent' => ($this->reserved * 100)  / $this->stock, 'theme' => 'warning'],
      (object)['name' => 'Emprestado', 'amount' => $this->borrowed, 'percent' => ($this->borrowed * 100)  / $this->stock, 'theme' => 'dark'   ]
    ];
  }
}