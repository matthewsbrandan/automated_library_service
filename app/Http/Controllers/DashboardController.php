<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transfer;

class DashboardController extends Controller{
  public function index(){
    if(auth()->user()->type === 'admin') return view('dashboard.admin');

    $book_suggestions = Book::where('available','>', 0)->take(6)->inRandomOrder()->get();
    $allTransfers = Transfer::whereUserId(auth()->user()->id)->whereFinished(false)->get();
    $transfers = collect([]);
    $reservations = collect([]);

    foreach($allTransfers as $trs){
      if($trs->status === 'reserved') $reservations->push($trs);
      else $transfers->push($trs);
    }

    return view('dashboard.index', [
      'book_suggestions' => $book_suggestions,
      'transfers' => $transfers,
      'reservations' => $reservations
    ]);
  }
}
