<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected function notify($redirect){
    /** ESTA FUNÇÃO RECEBE COMO PRIMEIRO PARAMETRO O REDIRECIONAMENTO,
     *  E OS DEMAIS PARAMETROS SERÃO APLICADOS NO WITH, UTILIZANDO 
     *  AS CHAVES DA VARIÁVEL ABAIXO(KEYS)
     *  **/ 
    
    $keys = ['notify','notify-type'];

    $args = func_get_args();
    $length = count($args);

    if($length <= 1) throw new Exception('É obrigatória a passagem de parametros para esta função');
    if($length > count($keys) + 1) throw new Exception('A quantidade de parametros excedeu o total suportado');

    foreach($args as $index => $arg){
      if($index == 0) continue;
      $redirect->with($keys[$index - 1], $arg);
    }

    return $redirect;
  }
}
