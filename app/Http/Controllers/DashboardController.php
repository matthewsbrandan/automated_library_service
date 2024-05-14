<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use App\Models\Book;
use App\Models\Transfer;

class DashboardController extends Controller{
  public function index(){
    if(auth()->user()->type === 'admin') return $this->indexAdmin();
    
    return $this->indexReader();
  }
  private function indexAdmin(){
    $transfers = Transfer::whereIn('status', ['reserved', 'borrowed', 'expired'])->whereFinished(false)->get();

    [$collectChart, $devolutionChart] = $this->getDataChart();

    return view('dashboard.admin', ['transfers' => $transfers, 'collectChart' => $collectChart, 'devolutionChart' => $devolutionChart]);
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
  private function getDataChart(){
    function formatMMYYYY($month, $year){
      $yearFormatted = $year - 2000;
      $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT);
      return "$monthFormatted/$yearFormatted";
    }
    // fazer um array dos últimos 12 meses, e usar o count para agrupar created_at === coletas returned_at === devoluções
    // adicionar o campo collected_at para ter uma data mais precisa de coleta e substituir o created_at neste relatório
    $twelveMonthsAgo = Carbon::now()->subMonths(12);
    $transfersForChart = Transfer::whereDate('created_at', '>=', $twelveMonthsAgo)->orWhereDate('returned_at', '>=', $twelveMonthsAgo)->get();

    $startMonth = $twelveMonthsAgo->month;
    $startYear  = $twelveMonthsAgo->year;

    $collectChart = (object)[];
    foreach(range($startMonth, 12 + $startMonth - 1) as $month){
      $yearFormatted = $startYear;

      if($month > 12){
        $month-=12;
        $yearFormatted++;
      }
      
      $key = formatMMYYYY($month, $yearFormatted);
      $collectChart->$key = 0;
    }
    $devolutionChart = json_decode(json_encode($collectChart));

    foreach($transfersForChart as $transfer){
      $key = formatMMYYYY($transfer->created_at->month, $transfer->created_at->year);

      if(property_exists($collectChart, $key)) $collectChart->$key++;

      $expiration = $transfer->Expiration();
      if($expiration){
        $key = formatMMYYYY($expiration->month, $expiration->year);
        if(property_exists($devolutionChart, $key)) $devolutionChart->$key++;
      }
    }

    return [$collectChart, $devolutionChart];
  }
}
