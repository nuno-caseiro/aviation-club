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
$movimentos = Movimento::paginate(15);
$title = "List of Movimentos";
return view('movimentos.list', compact('movimentos', 'title'));
}





    public function edit($id)
    {

      
        

        $title = "Editar movimentos ";
       $movimento= Movimento::find($id);
        // $aeronave = Aeronave::where('matricula', '=', $matricula)->first();

        return view('movimentos.edit', compact('title', 'movimento'));
    }






  


}
