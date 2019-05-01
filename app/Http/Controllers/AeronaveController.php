<?php

namespace App\Http\Controllers;

use App\Aeronave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AeronaveController extends Controller
{


    public function index(){
        $aeronaves= Aeronave::all();
        $title= "Lista de Aeronaves";
        return view('aeronaves.list', compact('aeronaves', 'title'));


    }

    public function edit($matricula)
    {
        $title = "Editar Aeronava ";
        $aeronave = Aeronave::where('matricula', '=', $matricula)->first();
        return view('aeronaves.edit', compact('title', 'aeronave'));
    }







 /*   public function update(Request $request, $matricula){

        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
        $user = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'age' => 'required|integer|between:1,120',
        ], [ // Custom Messages
            'name.regex' => 'Name must only contain letters and spaces.',
        ]);
//testes

        $aeronave = DB::table('aeronavesController')->where('matricula','==', $matricula)->get();


    }*/


}
