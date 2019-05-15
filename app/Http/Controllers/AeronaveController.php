<?php

namespace App\Http\Controllers;

use DB;
use App\Aeronave;
use App\AeronaveValores;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AeronaveController extends Controller
{
private $matricula;

    public function index(){
        if(Auth::user()->can('list', Auth::user())) {
            $aeronaves = Aeronave::all();
        }elseif(Auth::user()->can('normal_ativo', Auth::user())) {
            $aeronaves = Aeronave::all();
        }
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




        $aeronave=$request->all()+['conta_horas'=>'0', 'preco_hora'=>$request->precos[9]];

        Aeronave::create($aeronave);

        foreach(range(1,10) as $i){
/*
            $aeronaveValor[]= ['unidade_conta_horas' => $i,
                'minutos' => $request->minutos[$i-1], 'preco' => $request->precos[$i-1]];
*/
            Aeronave::find($request->matricula)->aeronaveValores()->create(['unidade_conta_horas' => $i,
                'minutos' => $request->minutos[$i-1], 'preco' => $request->precos[$i-1]]);
        }
        return redirect()->action('AeronaveController@index');
    }


    public function edit($matricula)
    {

        $title = "Editar Aeronave";
        $aeronave = Aeronave::find($matricula);

        $aeronaveValores= Aeronave::find($matricula)->aeronaveValores()->get()->toArray();




        return view('aeronaves.edit', compact('title', 'aeronave', 'aeronaveValores'));
    }


    public function update(Request $request, $matricula){


        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }
        //falta validacao

        $aeronaveModel= Aeronave::find($matricula);

        //request precos??
        $i=0;
        foreach ($request->precos as $preco){

            Aeronave::find($matricula)->aeronaveValores()->where('unidade_conta_horas',$i+1)->update(['preco'=> $request->precos[$i]]);
            Aeronave::find($matricula)->aeronaveValores()->where('unidade_conta_horas',$i+1)->update(['minutos'=> $request->minutos[$i]]);
            $i++;
        }

        $aeronaveModel->marca=$request->marca;
        $aeronaveModel->modelo=$request->modelo;
        $aeronaveModel->num_lugares= $request->nrlugares;
        $aeronaveModel->save();
        return redirect()->action('AeronaveController@index');

    }

    public function destroy($matricula){

        Aeronave::find($matricula)->aeronaveValores()->delete();
        $aeronave= Aeronave::find($matricula);
        $aeronave->delete();
        return redirect()->action('AeronaveController@index');

    }

    public function pilotosAutorizados($matricula){
        $title = "Pilotos autorizados";

        $users= DB::table('users')->get();


        $pilotosAutorizados= Aeronave::find($matricula)->pilotosAutorizados()->where('matricula','=',$matricula)->get();



        $this->matricula=$matricula;

        $pilotosNaoAutorizados= DB::table('users')->whereNotIn('id', function ($query){
            $query->select('piloto_id')->from('aeronaves_pilotos')
            ->where('matricula', $this->matricula);


        })->get();









        //posso ir buscar os nomes de cada um deles
        return view('aeronaves.pilotosautorizados_list', compact('title', 'pilotosAutorizados', 'matricula', 'pilotosNaoAutorizados', 'users'));



    }

    public function addPilotoAutorizado($matricula, $piloto){

DB::table('aeronaves_pilotos')->insert(['matricula'=>$matricula, 'piloto_id' =>$piloto]);

    }

    public function removePilotoAutorizado($matricula, $piloto){
        DB::table('aeronaves_pilotos')->where('piloto_id', 'piloto')->where('matricula', 'matricula')->delete();

    }


    public function precosTempos($matricula){
        $title= "Tempos e precos";
        $aeronaveValores= Aeronave::find($matricula)->aeronaveValores()->get()->toJson();

        return view('aeronaves.precoValores',compact('aeronaveValores', 'title', 'matricula'));

    }




}
