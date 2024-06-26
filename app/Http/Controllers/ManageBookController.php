<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\BookAuthor;
use App\Models\BookStock;
use App\Models\BookCategory;

use Illuminate\Http\Request;

class ManageBookController extends Controller{
  public function index(){
    $pagination = (object)['total' => 0, 'per_page' => 10, 'pages' => 1];

    $pagination->total = Book::count();
    $pagination->pages = ceil($pagination->total / $pagination->per_page);

    $books = Book::with(['bookStocks'])->orderBy('updated_at','desc')
      ->take($pagination->per_page)
      ->get();

    return view('manage.book.index', ['books' => $books, 'pagination' => $pagination]);
  }
  public function store(Request $request) {
    $validated = $request->validate([
      'title'          => 'required|max:255',
      'subtitle'       => 'max:255',
      'isbn'           => 'required|max:255',
      'published_date' => 'required',
      'description'    => 'required',
      'authors'        => 'max:255',
      'categories'     => 'max:255',
      'image'          => 'max:255',
      'rf_ids'         => 'required',
    ]);

    $rf_ids = json_decode($request->rf_ids);

    $stock = count($rf_ids);
    
    if($stock === 0) return $this->notify(
      redirect()->back(),
      'Adicione o rf-id de pelo menos 1 livro',
      'danger'
    );

    $book = Book::create([
      'title'          => $request->title,
      'subtitle'       => $request->subtitle,
      'isbn'           => $request->isbn,
      'published_date' => $request->published_date,
      'description'    => $request->description,
      'image'          => $request->image,
      'stock'          => $stock,
      'available'      => $stock,
      'reserved'       => 0,
      'borrowed'       => 0
    ]);

    $stockResponse = $this->linkBookAndStock($book->id, $rf_ids);
    if(!$stockResponse->result) return $this->notify(
      redirect()->back(),
      $stockResponse->response,
      'danger'
    );

    $authors = explode(',', $request->authors);
    $categories = explode(',', $request->categories);
    if(count($authors) > 0) $this->linkBookAndAuthor($book->id, $authors);
    if(count($categories) > 0) $this->linkBookAndCategories($book->id, $categories);

    return redirect()->route('manage.book.index')->with('message', 'Livro criado com sucesso');
  }
  public function update(Request $request, $id) {
    $book = Book::whereId($id)->first();
    if(!$book) return $this->notify(
      redirect()->back(),
      'Livro não encontrado',
      'danger'
    );

    $validated = $request->validate([
      'title'          => 'required|max:255',
      'subtitle'       => 'required|max:255',
      'isbn'           => 'required|max:255',
      'published_date' => 'required|max:4',
      'description'    => 'required',
      'authors'        => 'array',
      'categories'     => 'array',
      'image'          => 'max:255',
    ]);

    $rf_ids = $request->rf_ids ? json_decode($request->rf_ids) : [];

    $response = $this->handleUpdateBookAndStock($id, $rf_ids);
    if(!$response->result) return $this->notify(
      redirect()->back(),
      $response->response,
      'danger'
    );

    $stock = $book->stock + $response->data;
    $available = $book->available + $response->data;
    
    if($stock < 0) $stock = 0;
    if($available < 0) $available = 0;

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
      'stock'          => $stock,
      'available'      => $available
    ]);

    return $this->notify(
      redirect()->route('manage.book.index'),
      'Livro atualizado com sucesso',
      'success'
    );
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
      if(!$category) continue;

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
  private function linkBookAndStock($book_id, $rf_ids){
    foreach($rf_ids as $rf_id){
      $stock = BookStock::whereRfId($rf_id)->first();
      if(!$stock) BookStock::create([
        'rf_id' => $rf_id,
        'book_id' => $book_id,
        'status' => 'available',
        'transfer_id' => 0
      ]);
      else if($stock->book_id !== $book_id) return (object)[
        'result' => false,
        'response' => 'Este RF-ID já está sendo utilizado em outro livro'
      ];
    }

    return (object)[
      'result' => true,
      'response' => 'Link de livros e estoque realizado com sucesso'
    ];
  }
  private function handleUpdateBookAndStock($book_id, $rf_ids){
    $bookStocks = BookStock::whereBookId($book_id)->get();

    $modifier = 0; // adição ou remoção de quantidade de estoque

    $existents = [];
    foreach($bookStocks as $bookStock){
      if(!in_array($bookStock->rf_id, $rf_ids)){
        if($bookStock->status !== 'available') return (object)[
          'result'   => false,
          'response' => 'O rf-id ' . $bookStock->rf_id . ' não pode ser removido'
        ];
        
        $modifier--;
        $bookStock->delete();
      }
      else array_push($existents, $bookStock->rf_id);
    }

    foreach($rf_ids as $rf_id){
      if(!in_array($rf_id, $existents)){
        BookStock::create([
          'rf_id' => $rf_id,
          'book_id' => $book_id,
          'status' => 'available',
          'transfer_id' => 0
        ]);

        $modifier++;        
      }
    }

    return (object)['result' => true, 'response' => 'Estoque atualizado', 'data' => $modifier];
  }
  private function deleteRelationships($book_id){
    BookAuthor::whereBookId($book_id)->delete();
    BookCategory::whereBookId($book_id)->delete();
  }
  #endregion LOCAL FUNCTIONS
}