<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transfer;

use Illuminate\Http\Request;

class ManageDevolutionController extends Controller{
  public function index(){
    $pagination = (object)['total' => 0, 'per_page' => 10, 'pages' => 1];

    $pagination->total = Transfer::whereStatus('borrowed')->count();
    $pagination->pages = ceil($pagination->total / $pagination->per_page);

    $transfers = Transfer::whereStatus('borrowed')
      ->orderBy('expiration','desc')
      ->take($pagination->per_page)
      ->get();

    return view('manage.devolution.index', ['transfers' => $transfers, 'pagination' => $pagination]);
  }
  public function devolution(Request $request){
    if(!$request->rf_id) return response()->json([
      'result' => false,
      'response' => 'É obrigatório preencher o rf_id do livro'
    ]);

    $transfer = Transfer::whereRfId($request->rf_id)->first();

    if(!$transfer || !$transfer->bookStock) return response()->json([
      'result' => false,
      'response' => 'Devolução não encontrada'
    ]);

    if($transfer->status !== 'borrowed' && $transfer->status !== 'expired') return response()->json([
      'result' => false,
      'response' => 'O livro não está disponível para devolução',
    ]);

    $transfer->bookStock->update(['status' => 'available', 'transfer_id' => 0]);

    $transfer->update(['finished' => true]);
    
    $transfer->book->update([
      'borrowed' => $transfer->book->borrowed - 1,
      'available' => $transfer->book->available + 1,
    ]);
    
    return response()->json([
      'result' => true,
      'response' => 'Devolução registrada com sucesso',
    ]);
  }
}