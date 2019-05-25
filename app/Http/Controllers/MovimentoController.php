<?php

namespace App\Http\Controllers;
use App\Aeronave;
use App\User;
use App\Movimento;
use App\Aerodromo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Charts;
use DB;
use Illuminate\Support\Facades\Input;
class MovimentoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
       // if(Auth::user()->can('list', Auth::user())) {
       //     $movimentos = Movimento::paginate(15);
       // }elseif(Auth::user()->can('normal_ativo', Auth::user())) {
            


       // }









        $this->authorize('listar', Auth::user());





         $movimento_id=request()->query('movimento_id');
        $aeronave=request()->query('aeronave');
        $confirmado=request()->query('confirmado');
        $especial=request()->query('especial');
        $treino=request()->query('treino');
        $piloto=request()->query('piloto');
        $instrutor=request()->query('instrutor');
        $naturezaI=request()->query('naturezaI');
        $naturezaT=request()->query('naturezaT');
        $naturezaE=request()->query('naturezaE');
        $descolar=request()->query('descolar');
        $aterrar=request()->query('aterrar');
         $checkboxConfirmado=request()->query('checkboxConfirmado');
   
    
        $filtro = Movimento::where('id','>=','1');
        if (isset($aeronave)) {
            $filtro = $filtro->where('aeronave', $aeronave);
        }
         if (isset($naturezaT) || isset($naturezaI)||isset($naturezaE) ){
            $filtro = $filtro->where('natureza',$naturezaT)->orWhere('natureza',$naturezaI)->orWhere('natureza',$naturezaE);
        }
        
         if (isset($confirmado)) {
            $filtro = $filtro->where('confirmado', $confirmado);
        }
 
           if (isset($piloto)) {
            $filtro = $filtro->where('piloto_id',$piloto);
        }
 

        if (isset($instrutor)) {
            $filtro = $filtro->where('instrutor_id',$instrutor);
        }
 

            if (isset($aterrar)&&isset($descolar)) {
            $filtro = $filtro->where('hora_descolagem','>=',$descolar)->where('hora_aterragem','<=',$aterrar);
        }

            if (isset($movimento_id)) {//id do movimento
            $filtro = $filtro->where('id','=',$movimento_id);
        }
        $pressed=request()->query('movimentos');
       //meus movimentos
    $confirmarVarios=request()->query('confirmarVarios');
    if(!is_null($confirmarVarios) && $confirmarVarios=="true"){
       if(!is_null($checkboxConfirmado)){
     foreach ($checkboxConfirmado as $checked) {
        $movimento= Movimento::findOrFail($checked);
        $movimento->confirmado="1";
        //conflitos
        $movimento->save();
    }

     }
       
    }

        if($pressed=='true') {
            $users=User::all();
            $aeronaves=Aeronave::all();
            $filtro=$filtro->where('piloto_id','=',auth()->user()->id)->orWhere('instrutor_id','=',auth()->user()->id);
            $movimentos = $filtro->paginate(15)->appends([
                     'movimento_id' => request('movimento_id'),
                     'instrucao' => request('instrucao'),
                     'confirmado' => request('confirmado'),
                     'especial' => request('especial'),
                     'treino' => request('treino'),
                     'piloto' => request('piloto'),
                     'instrutor' => request('instrutor'),
                     'naturezaI' => request('naturezaI'),
                     'naturezaT' => request('naturezaT'),      
                     'naturezaE' => request('naturezaE'),
                     'descolar' => request('descolar'),
                     'aterrar' => request('aterrar'),      
                 ]);
      }else{
        //normal
        if(Auth::user()->can('socio_Direcao', Auth::user()) || Auth::user()->can('socio_Piloto', Auth::user())) {
        $aeronaves=Aeronave::all();
        $users=User::all();
        $movimentos = $filtro->paginate(15)->appends([
                     'movimento_id' => request('movimento_id'),
                     'instrucao' => request('instrucao'),
                     'confirmado' => request('confirmado'),
                     'especial' => request('especial'),
                     'treino' => request('treino'),
                     'piloto' => request('piloto'),
                     'instrutor' => request('instrutor'),
                     'naturezaI' => request('naturezaI'),
                     'naturezaT' => request('naturezaT'),      
                     'naturezaE' => request('naturezaE'),
                     'descolar' => request('descolar'),
                     'aterrar' => request('aterrar'),      
                 ]);
      }
    }

  
  
 

    $title = "List of Movimentos";
    $aerodromos=Aerodromo::all();
    $data=['naturezaE'=>$naturezaE,'naturezaT'=>$naturezaT,'naturezaI'=>$naturezaI,'confirmado'=>$confirmado,'movimento_id'=>$movimento_id,'aterrar'=>$aterrar,'descolar'=>$descolar,'piloto'=>$piloto,'instrutor'=>$instrutor,'aeronave'=>$aeronave];
      
        return view('movimentos.list', compact('movimentos', 'title', 'users','aeronaves','data','pressed','aerodromos'));
    }







    public function edit($id)
    {

        $title = "Editar movimentos ";
        $movimento= Movimento::findOrFail($id);
        $aeronaves=Aeronave::all();
        $socios=User::all();
          $aerodromos=Aerodromo::all();

        $movimento->hora_aterragem=self::parseDate($movimento->hora_aterragem);
         $movimento->hora_descolagem=self::parseDate($movimento->hora_descolagem);
        return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos'));
    }


    public function parseDate($value)
{
     return Carbon::parse($value)->format('Y-m-d\TH:i');
}



    public function update(Request $request, $id){

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
        //falta validacao
        $movimentoModel= Movimento::findOrFail($id);

        //dd($request->all());
        //protected $fillable = ['id', 'aeronave', 'data_inf??', ' data_sup??', 'natureza', 'confirmado???','piloto??','instrutor??','meus_movimentos??'];

        $movimentoModel->aeronave=$request->aeronave;
        $movimentoModel->natureza= $request->natureza;
       
         //dd($movimentoModel);
        if($request->natureza=='I'){
      $movimentoModel->piloto_id=$request->piloto_id;
        $movimentoModel->instrutor_id=$request->instrutor_id;
        $movimentoModel->tipo_instrucao=$request->tipo_instrucao;
        $movimentoModel->hora_aterragem=$request->hora_descolagem;
        $movimentoModel->hora_descolagem=$request->hora_aterragem;
        $movimentoModel->aerodromo_chegada=$request->aerodromo_chegada;
        $movimentoModel->aerodromo_partida=$request->aerodromo_partida;
        $movimentoModel->num_pessoas=$request->num_pessoas;
        }else{
        $movimentoModel->piloto_id=$request->piloto_id;
        $movimentoModel->instrutor_id=null;
        $movimentoModel->tipo_instrucao=null;
        $movimentoModel->hora_aterragem=$request->hora_descolagem;
        $movimentoModel->hora_descolagem=$request->hora_aterragem;
        $movimentoModel->aerodromo_chegada=$request->aerodromo_chegada;
        $movimentoModel->aerodromo_partida=$request->aerodromo_partida;
        $movimentoModel->num_pessoas=$request->num_pessoas;
        }
         if($request->submit == "confirmar")
      {
        $movimentoModel->confirmado=1;
      }else{
          $movimentoModel->confirmado=0;
      }
  


        $movimentoModel->save();
        return redirect()->action('MovimentoController@index');
        //podemos dar nomes às rotas
    }



    public function create(){
        $title= "Adicionar Movimento";
        $aeronaves=Aeronave::all();   
        $socios=User::all();
        $aerodromos=Aerodromo::all();
        $movimentos=Movimento::all();

        foreach ($aeronaves as $aeronave) {
        $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
        }
       

       return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','movimentos','valores'));
    }



    public function store(Request $request)
    { 
      $movimentos=Movimento::all();
        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
        $user= User::find($request->piloto_id);
        $instrutor=User::find($request->instrutor_id);
        $contaHorasInicial=$request->conta_horas_inicio;
        $contaHorasFinal=$request->conta_horas_fim;
        $aeronave=$request->aeronave;
        




        $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();

        if($request->natureza=="I"){
        $movimento=$request->all()+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'confirmado'=>'0','tipo_licenca_piloto'=>$user->tipo_licenca,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado,'numero_linceca_instrutor'=>$instrutor->num_licenca,'validade_licenca_instrutor'=>$instrutor->validade_licenca,'tipo_licenca_instrutor'=>$instrutor->tipo_licenca,'validade_certificado_instrutor'=>$instrutor->validade_certificado,'classe_certificado_instrutor'=>$instrutor->classe_certificado,'num_licenca_instrutor'=>$instrutor->num_licenca,'num_certificado_instrutor'=>$instrutor->num_certificado];
  }else{
      $movimento=$request->all()+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'confirmado'=>'0','tipo_licenca_piloto'=>$user->tipo_licenca,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado];
    }

      

/*
      $aux=0; 
      foreach ($movimentos as $m) {
        if($m->aeronave == $aeronave){
        if(($m->conta_horas_inicio<=$contaHorasInicial)  && ($m->conta_horas_fim >= $contaHorasFinal)){
        # code...
          //sobreposicao
          $movimento = new Movimento($movimento);
            $title="Conflito sobreposicao";
           return view('movimentos.conflitos', compact('title','movimento','movimentos','aeronaves','socios','aerodromos'));
      }
      if($m->conta_horas_fim==$contaHorasInicial){
        $aux=1;//encontrado o conta kilometros final
      }
    }
  }


    if($aux==0 ){
      //buraco
               $movimento = new Movimento($movimento);
               $title="Conflito Buraco";
               return view('movimentos.conflitos', compact('title','movimento','movimentos','aeronaves','socios','aerodromos'));
    }
  
*/


        Movimento::create($movimento);

        return redirect()->action('MovimentoController@index');
    }






    public function destroy($id){
        $movimento= Movimento::findOrFail($id);
        $movimento->delete();


        return redirect()->action('MovimentoController@index');

    }


    public function estatisticas(){
       $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))
                    ->get();
        $chart = Charts::database($users, 'bar', 'highcharts')
                  ->title("Monthly new Register Users")
                  ->elementLabel("Total Users")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupByMonth(date('Y'), true);

        $pie  =  Charts::create('pie', 'highcharts')
                    ->title('My nice chart')
                    ->labels(['First', 'Second', 'Third'])
                    ->values([5,10,20])
                    ->dimensions(1000,500)
                    ->responsive(false);
        return view('movimentos.estatisticas',compact('chart','pie'));
    }   




}
