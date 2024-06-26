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
  public function categories(){
    return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
  }
  public function bookStocks(){
    return $this->hasMany(BookStock::class, 'book_id');
  }

  public function getAuthorNames(){
    if(isset($this->authors)) return $this->authors->map(function($author){ return $author->name; });
    return collect([]);
  }
  public function getCategoryNames(){
    if(isset($this->categories)) return $this->categories->map(function($category){ return $category->name; });
    return collect([]);
  }
  public function getStockResume(){
    return [
      (object)['name' => 'Disponível', 'amount' => $this->available,'percent' => $this->stock === 0 ? 0 : ($this->available * 100) / $this->stock, 'theme' => 'success'],
      (object)['name' => 'Reservados', 'amount' => $this->reserved, 'percent' => $this->stock === 0 ? 0 : ($this->reserved * 100)  / $this->stock, 'theme' => 'warning'],
      (object)['name' => 'Emprestado', 'amount' => $this->borrowed, 'percent' => $this->stock === 0 ? 0 : ($this->borrowed * 100)  / $this->stock, 'theme' => 'dark'   ]
    ];
  }
}