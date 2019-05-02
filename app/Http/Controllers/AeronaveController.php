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

    public function create(){
        $title= "Adicionar aeronave";
        return view('aeronaves.create', compact('title'));
    }

    public function store(Request $request)
    {
        $title = "Editar Aeronave ";
        $aeronave = Aeronave::where('matricula', '=', $matricula)->first();
        return view('aeronaves.edit', compact('title', 'aeronave'));
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
      /*  $user = $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u',
            'age' => 'required|integer|between:1,120',
        ], [ // Custom Messages
            'name.regex' => 'Name must only contain letters and spaces.',
        ]);*/

        $aeronave=$request->all()+['conta_horas'=>'0', 'preco_hora'=>'0'];

        Aeronave::create($aeronave);
        return redirect()->action('AeronaveController@index');
    }


    public function edit($matricula)
    {

        $title = "Editar Aeronave";
        $aeronave = Aeronave::where('matricula', '=', $matricula)->first();

        $title = "Editar Aeronava ";
       $aeronave= Aeronave::find($matricula);
        // $aeronave = Aeronave::where('matricula', '=', $matricula)->first();

        return view('aeronaves.edit', compact('title', 'aeronave'));
    }


    public function update(Request $request, $matricula){

        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
        //falta validacao

        $aeronaveModel= Aeronave::where('matricula','=', $matricula)->first();
        $aeronaveModel->num_lugares= $request->nrlugares;
        $aeronaveModel->save();
        return redirect()->action('AeronaveController@index');
        //podemos dar nomes às rotas
    }

    public function destroy($matricula){
        $aeronave= Aeronave::find($matricula);
        $aeronave->delete();
        return redirect()->action('AeronaveController@index');

    }


}
