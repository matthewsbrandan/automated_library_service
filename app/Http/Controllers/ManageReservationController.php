<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transfer;

use Illuminate\Http\Request;

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
}