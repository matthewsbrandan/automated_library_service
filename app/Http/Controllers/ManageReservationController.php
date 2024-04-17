<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\BookStock;
use App\Models\Transfer;

class ManageReservationController extends Controller{
  public function index(){
    $pagination = (object)['total' => 0, 'per_page' => 10, 'pages' => 1];

    $pagination->total = Transfer::whereStatus('reserved')->count();
    $pagination->pages = ceil($pagination->total / $pagination->per_page);

    $transfereds = Transfer::whereStatus('reserved')
      ->orderBy('expiration','desc')
      ->take($pagination->per_page)
      ->get();

    return view('manage.reservation.index', ['books' => collect([]), 'pagination' => $pagination]);
  }
  public function makeReservation($book_id){
    $bookStock = BookStock::whereId($book_id)->whereStatus('available')->first();

    if(!$bookStock) return $this->notify(
      redirect()->back(),
      'Não há unidades disponíveis deste livro',
      'danger'
    );

    $expiration =  Carbon::now()->addHours(24);
    $transfer = Transfer::create([
      'status' => 'reserved',
      'book_id' => $book_id,
      'user_id' => auth()->user()->id,
      'expiration' => $expiration,
      'rf_id' => $bookStock->rf_id,
      'renewals' => 0,
      'finished' => false
    ]);
    $bookStock->update(['status' => 'reserved']);
    $bookStock->book->update([
      'available' => $bookStock->book->available - 1,
      'reserved' => $bookStock->book->reserved + 1,
      'transfer_id' => $transfer->id
    ]);

    return $this->notify(
      redirect()->back(),
      'Livro reservado com sucesso',
      'success'
    );
  }
}