<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transfer;

use Illuminate\Http\Request;

class ManageDevolutionController extends Controller{
  public function index(){
    $pagination = (object)['total' => 0, 'per_page' => 10, 'pages' => 1];

    $pagination->total = Book::count();
    $pagination->pages = ceil($pagination->total / $pagination->per_page);

    $books = Book::orderBy('updated_at','desc')
      ->take($pagination->per_page)
      ->get();

    return view('manage.devolution.index', ['books' => $books, 'pagination' => $pagination]);
  }
}