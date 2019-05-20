<?php

namespace App\Http\Controllers;

use App\Http\Requests\AeronaveCreate;
use App\Http\Requests\AeronaveUpdate;
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

        $this->authorize('listar', Auth::user());

        if(Auth::user()->can('socio_Direcao', Auth::user())) {
            $aeronaves = Aeronave::all();
        }elseif(Auth::user()->can('socio_Piloto', Auth::user())) {



            $aeronavesMatriculas= DB::table('aeronaves_pilotos')->select('matricula')->where('piloto_id',Auth::id())->pluck('matricula');
            foreach ($aeronavesMatriculas as $matricula){
                $aeronaves[]=Aeronave::findOrFail($matricula);
            }


        }else{
            $aeronaves = Aeronave::all();

        }

        foreach ($aeronaves as $aeronave){
            $aeronaveValores1= Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
            if(!empty($aeronaveValores1)){
                if($aeronaveValores1[count($aeronaveValores1)-1]['unidade_conta_horas']==10)
                    $aeronave->preco_hora= $aeronaveValores1[count($aeronaveValores1)-1]['preco'];
            }
        }



        $title= "Lista de Aeronaves";

        return view('aeronaves.list', compact('aeronaves', 'title'));



    }

    public function create(){
        $this->authorize('socio_Direcao',Auth::user());
        $title= "Adicionar aeronave";
        return view('aeronaves.create', compact('title'));
    }

    public function store(AeronaveCreate $request)
    {
        $this->authorize('socio_Direcao',Auth::user());
        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $aeronave=$request->all();

        Aeronave::create($aeronave);

        foreach(range(1,10) as $i){

            Aeronave::findOrFail($request->matricula)->aeronaveValores()->create(['unidade_conta_horas' => $i,
                'minutos' => $request->tempos[$i-1], 'preco' => $request->precos[$i-1]]);
        }
        return redirect()->action('AeronaveController@index');
    }


    public function edit($matricula)
    {
        $this->authorize('socio_Direcao',Auth::user() );

        $title = "Editar Aeronave";
        $aeronave = Aeronave::findOrFail($matricula);

        $aeronaveValores= Aeronave::findOrFail($matricula)->aeronaveValores()->get()->toArray();




        return view('aeronaves.edit', compact('title', 'aeronave', 'aeronaveValores'));
    }


    public function update(AeronaveUpdate $request, $matricula){
        $this->authorize('socio_Direcao',Auth::user());

        if ($request->has('cancel')) {
            return redirect()->action('AeronaveController@index');
        }

        $aeronaveModel= Aeronave::findOrFail($matricula);
        $aeronaveModel->fill($request->except(['created_at', 'updated_at', 'deleted_at']));
        $aeronaveModel->save();

        $i=0;

        if(isset($request->precos)){
            foreach ($request->precos as $preco){

                DB::table('aeronaves_valores')->where('matricula', $matricula)->where('unidade_conta_horas', $i+1)->update(['preco' => $request->precos[$i]]);
                DB::table('aeronaves_valores')->where('matricula', $matricula)->where('unidade_conta_horas', $i+1)->update(['minutos' => $request->tempos[$i]]);
                 // Aeronave::findOrFail($matricula)->aeronaveValores()->where('unidade_conta_horas',$i+1)->update(['preco'=> $request->precos[$i],'minutos'=> $request->tempos[$i] ]);
             //   Aeronave::find($matricula)->aeronaveValores()->where('unidade_conta_horas',$i+1)->update(['minutos'=> $request->tempos[$i]]);
                $i++;
            }

        }
        return redirect()->action('AeronaveController@index');

    }

    public function destroy($matricula){

        $this->authorize('socio_Direcao', Auth::user());
        Aeronave::find($matricula)->aeronaveValores()->delete();
        $aeronave= Aeronave::findOrFail($matricula);
        $movimentosAssociados= DB::table('movimentos')->select('id')->where('aeronave',$matricula)->get();
        if($movimentosAssociados->isEmpty()){
            $aeronave->forceDelete();
        }
        else {
            $aeronave->delete(); // faz soft delete

        }

        return redirect()->action('AeronaveController@index');

    }

    public function pilotosAutorizados($matricula){
        $title = "Pilotos autorizados";

        $users= DB::table('users')->get();


        $pilotosAutorizados= Aeronave::findOrFail($matricula)->pilotosAutorizados()->where('matricula','=',$matricula)->get();



        $this->matricula=$matricula;

        $pilotosNaoAutorizados= DB::table('users')->whereNotIn('id', function ($query){
            $query->select('piloto_id')->from('aeronaves_pilotos')
                ->where('matricula', $this->matricula);


        })->get();

        return view('aeronaves.pilotosautorizados_list', compact('title', 'pilotosAutorizados', 'matricula', 'pilotosNaoAutorizados', 'users'));

    }

    public function addPilotoAutorizado($matricula, $piloto){

        DB::table('aeronaves_pilotos')->insert(['matricula'=>$matricula, 'piloto_id' =>$piloto]);
        return redirect()->action('AeronaveController@index');
    }

    public function removePilotoAutorizado($matricula, $piloto){
        DB::table('aeronaves_pilotos')->where('matricula', $matricula)->where('piloto_id', $piloto)->delete();
        return redirect()->action('AeronaveController@index');

    }


    public function precosTempos($matricula){
        $title= "Tempos e precos";
        $aeronaveValores= Aeronave::findOrFail($matricula)->aeronaveValores()->get()->toJson();

        return view('aeronaves.precoValores',compact('aeronaveValores', 'title', 'matricula'));

    }




}
