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

    }


}
