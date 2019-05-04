<?php

namespace App\Http\Controllers;

use App\Aeronave;
use App\AeronaveValores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AeronaveController extends Controller
{


    public function index(){
        $aeronaves= Aeronave::all();
        foreach ($aeronaves as $aeronave){
            $aeronaveValores1= Aeronave::find($aeronave->matricula)->aeronaveValores()->get()->toArray();
            if(!empty($aeronaveValores1)){
                if($aeronaveValores1[count($aeronaveValores1)-1]['unidade_conta_horas']==10)
                $aeronave->preco_hora= $aeronaveValores1[count($aeronaveValores1)-1]['preco'];
            }
        }

        $title= "Lista de Aeronaves";

        return view('aeronaves.list', compact('aeronaves', 'title'));


    }

    public function create(){
        $title= "Adicionar aeronave";
        return view('aeronaves.create', compact('title'));
    }

    public function store(Request $request)
    {
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
        $aeronave = Aeronave::find($matricula);

          $aeronaveValores= Aeronave::find($matricula)->aeronaveValores()->get()->toArray();


        $title = "Editar Aeronave ";
       $aeronave= Aeronave::find($matricula);
        // $aeronave = Aeronave::where('matricula', '=', $matricula)->first();

        return view('aeronaves.edit', compact('title', 'aeronave', 'aeronaveValores'));
    }


    public function update(Request $request, $matricula){

        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
        //falta validacao

        $aeronaveModel= Aeronave::find($matricula);

        $preco[]=null;
       array_push($preco, $request->preco0, $request->preco1, $request->preco2, $request->preco3, $request->preco4, $request->preco5, $request->preco6, $request->preco7,$request->preco8, $request->preco9);

        for($i=1; $i<count($preco); $i++){
            $aeronaveValores= Aeronave::find($matricula)->aeronaveValores()->where('unidade_conta_horas',$i)->update(['preco'=> $preco[$i]]);
        }

      //falta


        $aeronaveModel->marca=$request->marca;
        $aeronaveModel->modelo=$request->modelo;
        $aeronaveModel->num_lugares= $request->nrlugares;
        $aeronaveModel->save();
        return redirect()->action('AeronaveController@index');

    }

    public function destroy($matricula){
        $aeronave= Aeronave::find($matricula);
        $aeronave->delete();
        return redirect()->action('AeronaveController@index');

    }


}
