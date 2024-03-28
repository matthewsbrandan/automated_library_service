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
    return view('tables');
  }
  public function store(Request $request) : RedirectResponse{
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
    ]);
    
    if(count($request->authors) > 0) $this->linkBookAndAuthor($book->id, $request->authors);
    if(count($request->categories) > 0) $this->linkBookAndCategories($book->id, $request->categories);

    return redirect('manage.book.index')->with('message', 'Livro criado com sucesso');
  }

  private function linkBookAndAuthor($book_id, $authors){
    foreach($authors as $author){
      $findedAuthor = Author::whereName($author)->first();
      
      if(!$findedAuthor) $findedAuthor = Author::create([
        'name' => $author
      ]);

      BookAuthor::create([
        'book_id'   => $book->id,
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
        'book_id'   => $book->id,
        'category_id' => $findedCategory->id
      ]);
    }
  }
}