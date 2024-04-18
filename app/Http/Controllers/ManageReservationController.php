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
    $bookStock = BookStock::whereBookId($book_id)->whereStatus('available')->first();
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
    $bookStock->update([
      'status' => 'reserved',
      'transfer_id' => $transfer->id
    ]);
    $bookStock->book->update([
      'available' => $bookStock->book->available - 1,
      'reserved' => $bookStock->book->reserved + 1,
    ]);

    return $this->notify(
      redirect()->back(),
      'Livro reservado com sucesso',
      'success'
    );
  }
  public function collectReservation(Request $request){
    if(!$request->rf_id) return $this->notify(
      redirect()->back(),
      'É obrigatório preencher o rf_id do livro',
      'danger'
    );

    $bookStock = BookStock::whereRfId($request->rf_id)->first();
    if(!$bookStock) return $this->notify(
      redirect()->back(),
      'Livro não encontrado',
      'danger'
    );

    if($bookStock->status === 'borrowed') return $this->notify(
      redirect()->back(),
      'Este livro não está disponível',
      'danger'
    );

    $expiration =  Carbon::now()->addDays(5);

    if($bookStock->status === 'reserved'){
      if(!$bookStock->transfer || $bookStock->transfer->user_id !== auth()->user()->id) return $this->notify(
        redirect()->back(),
        'Este livro não pode ser coletado, pois foi reservado p/ outra pessoa',
        'danger'
      );
 
      $bookStock->update(['status' => 'borrowed']);

      $bookStock->transfer->update([
        'expiration' => $expiration,
        'status' => 'borrowed'
      ]);
      
      $bookStock->book->update([
        'reserved' => $bookStock->book->reserved - 1,
        'borrowed' => $bookStock->book->borrowed + 1,
      ]);
    }else{
      $transfer = Transfer::create([
        'status' => 'borrowed',
        'book_id' => $bookStock->book_id,
        'user_id' => auth()->user()->id,
        'expiration' => $expiration,
        'rf_id' => $bookStock->rf_id,
        'renewals' => 0,
        'finished' => false
      ]);

      $bookStock->update(['status' => 'borrowed', 'transfer_id' => $transfer->id]);

      $bookStock->book->update([
        'available' => $bookStock->book->available - 1,
        'borrowed' => $bookStock->book->borrowed + 1,
      ]);
    }

    return $this->notify(
      redirect()->back(),
      'Coleta registrada com sucesso',
      'success'
    );
  }
}