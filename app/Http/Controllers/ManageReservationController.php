<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\BookStock;
use App\Models\Transfer;

class ManageReservationController extends Controller{
  public function index(){
    $pagination = (object)[
      'requested' => (object)['total' => 0, 'per_page' => 10, 'pages' => 1],
      'reserved' =>  (object)['total' => 0, 'per_page' => 10, 'pages' => 1]
    ];

    $datas = (object)['requested' => collect([]), 'reserved' => collect([])];

    foreach(['requested', 'reserved'] as $table){
      $pagination->$table->total = Transfer::whereStatus($table)->count();
      $pagination->$table->pages = ceil($pagination->$table->total / $pagination->$table->per_page);

      $datas->$table = Transfer::whereStatus($table)
        ->orderBy('expiration','desc')
        ->take($pagination->$table->per_page)
        ->get();
    }
    
    return view('manage.reservation.index', [
      'requesteds'  => $datas->requested,
      'reserveds'   => $datas->reserved,
      'pagination' => $pagination
    ]);
  }
  public function requestReservation($book_id){
    $book = Book::whereId($book_id)->first();
    if(!$book) return $this->notify(
      redirect()->back(),
      'Livro não encontrado',
      'danger'
    );
    if($book->available <= 0) return $this->notify(
      redirect()->back(),
      'Não há unidades disponíveis deste livro',
      'danger'
    );
    
    $expiration =  Carbon::now()->addHours(24);
    $transfer = Transfer::create([
      'status' => 'requested',
      'book_id' => $book_id,
      'user_id' => auth()->user()->id,
      'expiration' => $expiration,
      'rf_id' => '',
      'renewals' => 0,
      'finished' => false
    ]);
    
    $book->update([
      'available' => $book->available - 1,
      'reserved' => $book->reserved + 1,
    ]);

    return $this->notify(
      redirect()->back(),
      'Solicitação de reserva enviada com sucesso',
      'success'
    );
  }
  public function refuseReservation($book_id){
    return $this->notify(
      redirect()->back(),
      'Em desenvolvimento',
      'danger'
    );
  }
  public function separateReservation($transfer_id, $rf_id){
    $transfer = Transfer::whereId($transfer_id)->first();
    if(!$transfer || $transfer->status !== 'requested') return $this->notify(
      redirect()->back(),
      'Solicitação de reserva não encontrada, ou não está com status correto',
      'danger'
    );
    
    $bookStock = BookStock::whereBookId($transfer->book_id)->whereRfId($rf_id)->whereStatus('available')->first();
    if(!$bookStock) return $this->notify(
      redirect()->back(),
      'Livro não encontrado ou não disponível',
      'danger'
    );

    $expiration =  Carbon::now()->addHours(24);
    $transfer->update([
      'status' => 'reserved',
      'expiration' => $expiration,
      'rf_id' => $rf_id
    ]);
    $bookStock->update([
      'status' => 'reserved',
      'transfer_id' => $transfer->id
    ]);
    
    return $this->notify(
      redirect()->back(),
      'Livro separado com sucesso',
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