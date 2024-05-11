<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
      'rf_id' => $rf_id,
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
  public function generateCollectToken($transfer_id){
    $transfer = Transfer::whereUserId(auth()->user()->id)->whereId($transfer_id)->first();
    if(!$transfer || !$transfer->rf_id) return response()->json([
      'result' => false, 'response' => 'Reserva não encontrada, ou livro ainda não separado'
    ]);

    if($transfer->token) return response()->json([
      'result' => true,
      'response' => 'Token de coleta já existe',
      'data' => $transfer->token
    ]);

    $token = null;
    $counter=0;
    do{
      $token = null;
      if($counter >= 10) break;
      $token = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
      $counter++;
    }while(!!Transfer::whereStatus('reserved')->whereToken($token)->first());

    if(!$token) return response()->json([
      'result' => false,
      'response' => 'Não foi possível gerar um código para coleta do livro',
    ]);
    $transfer->update(['token' => $token]);

    return response()->json([
      'result' => true,
      'response' => 'Token gerado com sucesso',
      'data' => $token
    ]);
  }
  public function collectReservation(Request $request){
    if(!$request->token) return response()->json([
      'result' => false,
      'response' => 'É obrigatório preencher o token do livro'
    ]);

    $transfer = Transfer::whereToken($request->token)->first();

    if(!$transfer || !$transfer->bookStock) return response()->json([
      'result' => false,
      'response' => 'Reserva não encontrada'
    ]);

    if($transfer->status !== 'reserved') return response()->json([
      'result' => false,
      'response' => 'O livro não está disponível para coleta',
    ]);

    $expiration =  Carbon::now()->addDays(5);
     
    $transfer->bookStock->update(['status' => 'borrowed']);

    $transfer->update([
      'expiration' => $expiration,
      'status' => 'borrowed',
      'token' => null
    ]);
    
    $transfer->book->update([
      'reserved' => $transfer->book->reserved - 1,
      'borrowed' => $transfer->book->borrowed + 1,
    ]);
    
    return response()->json([
      'result' => true,
      'response' => 'Coleta registrada com sucesso',
    ]);
  }
}