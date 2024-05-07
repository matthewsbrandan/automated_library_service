<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transfer;

class DashboardController extends Controller{
  public function index(){
    if(auth()->user()->type === 'admin') return $this->indexAdmin();
    
    return $this->indexReader();
  }
  private function indexAdmin(){
    $transfers = Transfer::whereIn('status', ['reserved', 'borrowed', 'expired'])->whereFinished(false)->get();

    return view('dashboard.admin', ['transfers' => $transfers]);
  }
  private function indexReader(){
    $book_suggestions = Book::where('available','>', 0)->take(6)->inRandomOrder()->get();
    $allTransfers = Transfer::whereUserId(auth()->user()->id)->whereFinished(false)->get();
    $transfers = collect([]);
    $reservations = collect([]);

    foreach($allTransfers as $trs){
      if($trs->status === 'requested' || $trs->status === 'reserved') $reservations->push($trs);
      else $transfers->push($trs);
    }

    return view('dashboard.index', [
      'book_suggestions' => $book_suggestions,
      'transfers' => $transfers,
      'reservations' => $reservations
    ]);
  }
}
