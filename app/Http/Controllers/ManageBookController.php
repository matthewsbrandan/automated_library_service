<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\BookAuthor;
use App\Models\BookCategory;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageBookController extends Controller{
  public function index(){
    $books = Book::orderBy('updated_at','desc')
      ->take(10)
      ->get();

    return view('tables', ['books' => $books]);
  }
  public function store(Request $request) {
    $validated = $request->validate([
      'title'          => 'required|max:255',
      'subtitle'       => 'max:255',
      'isbn'           => 'max:255',
      'published_date' => 'max:4',
      'description'    => 'required',
      'authors'        => 'array',
      'categories'     => 'array',
      'image'          => 'max:255',
      'stock'          => 'integer',
    ]);

    $book = Book::create([
      'title'          => $request->title,
      'subtitle'       => $request->subtitle,
      'isbn'           => $request->isbn,
      'published_date' => $request->published_date,
      'description'    => $request->description,
      'authors'        => $request->authors,
      'categories'     => $request->categories,
      'image'          => $request->image,
      'stock'          => $request->stock,
      'available'      => $request->stock,
      'reserved'       => 0,
      'borrowed'       => 0
    ]);
    
    if(count($request->authors) > 0) $this->linkBookAndAuthor($book->id, $request->authors);
    if(count($request->categories) > 0) $this->linkBookAndCategories($book->id, $request->categories);

    return redirect()->route('manage.book.index')->with('message', 'Livro criado com sucesso');
  }

  private function linkBookAndAuthor($book_id, $authors){
    foreach($authors as $author){
      $findedAuthor = Author::whereName($author)->first();
      
      if(!$findedAuthor) $findedAuthor = Author::create([
        'name' => $author
      ]);

      BookAuthor::create([
        'book_id'   => $book_id,
        'author_id' => $findedAuthor->id
      ]);
    }
  }
  private function linkBookAndCategories($book_id, $categories){
    foreach($categories as $category){
      $findedCategory = Category::whereName($category)->first();
      
      if(!$findedCategory) $findedCategory = Category::create([
        'name' => $category
      ]);

      BookCategory::create([
        'book_id'   => $book_id,
        'category_id' => $findedCategory->id
      ]);
    }
  }
}