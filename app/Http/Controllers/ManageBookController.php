<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\BookAuthor;
use App\Models\BookCategory;

use Illuminate\Http\Request;

class ManageBookController extends Controller{
  public function index(){
    $pagination = (object)['total' => 0, 'per_page' => 10, 'pages' => 1];

    $pagination->total = Book::count();
    $pagination->pages = ceil($pagination->total / $pagination->per_page);

    $books = Book::orderBy('updated_at','desc')
      ->take($pagination->per_page)
      ->get();

    return view('manage.book.index', ['books' => $books, 'pagination' => $pagination]);
  }
  public function store(Request $request) {
    $validated = $request->validate([
      'title'          => 'required|max:255',
      'subtitle'       => 'max:255',
      'isbn'           => 'required|max:255',
      'published_date' => 'required|max:4',
      'description'    => 'required',
      'authors'        => 'max:255',
      'categories'     => 'max:255',
      'image'          => 'max:255',
      'stock'          => 'required|integer',
    ]);

    $book = Book::create([
      'title'          => $request->title,
      'subtitle'       => $request->subtitle,
      'isbn'           => $request->isbn,
      'published_date' => $request->published_date,
      'description'    => $request->description,
      'image'          => $request->image,
      'stock'          => $request->stock,
      'available'      => $request->stock,
      'reserved'       => 0,
      'borrowed'       => 0
    ]);

    $authors = explode(',', $request->authors);
    $categories = count($request->categories);
    if(count($authors) > 0) $this->linkBookAndAuthor($book->id, $authors);
    if(count($categories) > 0) $this->linkBookAndCategories($book->id, $categories);

    return redirect()->route('manage.book.index')->with('message', 'Livro criado com sucesso');
  }
  public function update(Request $request, $id) {
    $book = Book::whereId($id)->first();
    if(!$book) return redirect()->route('manage.book.index')->with('message', 'Livro não encontrado');

    $validated = $request->validate([
      'title'          => 'required|max:255',
      'subtitle'       => 'required|max:255',
      'isbn'           => 'required|max:255',
      'published_date' => 'required|max:4',
      'description'    => 'required',
      'authors'        => 'array',
      'categories'     => 'array',
      'image'          => 'max:255',
      'stock'          => 'required|integer',
      'available'      => 'required|integer',
      'reserved'       => 'required|integer',
      'borrowed'       => 'required|integer'
    ]);

    $this->deleteRelationships($id);

    if(count($request->authors) > 0) $this->linkBookAndAuthor($book->id, $request->authors);
    if(count($request->categories) > 0) $this->linkBookAndCategories($book->id, $request->categories);

    $book->update([
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
      'reserved'       => $request->reserved,
      'borrowed'       => $request->borrowed
    ]);

    return redirect()->route('manage.book.index')->with('message', 'Livro atualizado com sucesso');
  }
  public function delete($id){
    $book = Book::whereId($id)->first();
    if(!$book) return redirect()->route('manage.book.index')->with('message', 'Livro não encontrado');

    $this->deleteRelationships($id);
    Book::whereId($id)->delete();

    return redirect()->route('manage.book.index')->with('message', 'Livro excluído com sucesso');
  }

  #region LOCAL FUNCTIONS
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
  private function deleteRelationships($book_id){
    BookAuthor::whereBookId($book_id)->delete();
    BookCategory::whereBookId($book_id)->delete();
  }
  #endregion LOCAL FUNCTIONS
}