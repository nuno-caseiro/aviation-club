<?php

namespace App\Http\Controllers;
use App\Movimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovimentoController extends Controller
{
    //
    public function index()
{
$movimentos = Movimento::all();
$title = "List of Movimentos";
return view('movimentos.list', compact('movimentos', 'title'));
}

}
