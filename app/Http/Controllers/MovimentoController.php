<?php

namespace App\Http\Controllers;
use App\Aeronave;
use App\Http\Requests\MovimentoCreate;
use App\Http\Requests\MovimentoUpdate;
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


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $this->authorize('listar', Auth::user());

        $movimento_id=request()->query('id');
        $aeronave=request()->query('aeronave');
        $confirmado=request()->query('confirmado');
        $especial=request()->query('especial');
        $treino=request()->query('treino');
        $piloto=request()->query('piloto');
        $instrutor=request()->query('instrutor');
        $natureza=request()->query('natureza');
        $data_inf=request()->query('data_inf');
        $data_sup=request()->query('data_sup');
        $checkboxConfirmado=request()->query('checkboxConfirmado');
        $meusMovimentos=request()->query('meus_movimentos');

        $filtro = Movimento::where('id','>=','1');

        if (isset($movimento_id)) {
            $filtro = $filtro->where('id', $movimento_id);
        }

        if(isset($data_inf)){
            $filtro = $filtro->where('data','>=', $data_inf);
        }

        if(isset($data_sup)){
            $filtro = $filtro->where('data','<=', $data_sup);
        }


        if (isset($aeronave)) {
            $filtro = $filtro->where('aeronave', $aeronave);
        }
        if (isset($natureza)){
            $filtro = $filtro->where('natureza',$natureza);
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

         if (isset($meusMovimentos)) {

            $filtro = $filtro->where('piloto_id',Auth::id())->orWhere('instrutor_id', Auth::id());
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

        if(Auth::user()->can('socio_piloto', Auth::user())){
            $users=User::all();
            $aeronaves=Aeronave::all();
            $movimentos = $filtro->paginate(15)->appends([
                'movimento_id' => request('movimento_id'),
                'instrucao' => request('instrucao'),
                'confirmado' => request('confirmado'),
                'especial' => request('especial'),
                'treino' => request('treino'),
                'piloto' => request('piloto'),
                'instrutor' => request('instrutor'),
                'meus_movimentos'=>request('meus_movimentos'),

            ]);
        }else{

            //normal
            if(Auth::user()->can('socio_Direcao', Auth::user()) || Auth::user()->can('socio_normal', Auth::user())) {



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
                    'meus_movimentos'=>request('meus_movimentos'),

                ]);
            }

        }





        $title = "List of Movimentos";
        $aerodromos=Aerodromo::all();
        $data=['movimento_id'=>$movimento_id,'piloto'=>$piloto,'instrutor'=>$instrutor,'aeronave'=>$aeronave];

        return view('movimentos.list', compact( 'title', 'users','movimentos','aeronaves','data','pressed','aerodromos'));
    }







    public function edit($id)
    {
        $this->authorize('socio_DP',Auth::user()) ;

        $title = "Editar movimentos ";
        $movimento= Movimento::findOrFail($id);
        $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();


        return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos'));
    }


    public function parseDate($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i:s');
    }



    public function update(MovimentoUpdate $request, $id){


        $this->authorize('socio_DP',Auth::user()) ;
       // $this->authorize('updateMovimentos', Auth::user(),$request->piloto_id);

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }


        $movimentoModel= Movimento::findOrFail($id);
        $user=User::findOrFail(Auth::id());
        $instrutor=User::find($request->instrutor_id);


    if ($request->natureza != 'I' && $movimentoModel->confirmado == 0 && ($movimentoModel->piloto_id == $user->id)) {

        /* $movimentoModel=$request->except(['created_at','updated_at','tipo_conflito','justificacao_conflito'])+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'confirmado'=>'0','tipo_licenca_piloto'=>$user->tipo_licenca
                 ,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado];*/

        if ($movimentoModel->piloto_id != $request->piloto_id) {
            $newPilot = User::findOrFail($request->piloto_id);
            $movimentoModel->num_licenca_piloto = $newPilot->num_licenca;
            $movimentoModel->tipo_licenca_piloto = $newPilot->tipo_licenca;
            $movimentoModel->validade_licenca_piloto = $newPilot->validade_licenca;
            $movimentoModel->num_certificado_piloto = $newPilot->num_certificado;
            $movimentoModel->classe_certificado_piloto = $newPilot->classe_certificado;
            $movimentoModel->validade_certificado_piloto = $newPilot->validade_certificado;
            /*$movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
            $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);*/

        } else {
            $movimentoModel->fill($request->except(['created_at', 'updated_at', 'tipo_conflito', 'justificacao_conflito']));
            //$movimentoModel['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'confirmado'=>'0','tipo_licenca_piloto'=>$user->tipo_licenca,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado,'numero_linceca_instrutor'=>$instrutor->num_licenca,'validade_licenca_instrutor'=>$instrutor->validade_licenca,'tipo_licenca_instrutor'=>$instrutor->tipo_licenca,'validade_certificado_instrutor'=>$instrutor->validade_certificado,'classe_certificado_instrutor'=>$instrutor->classe_certificado,'num_licenca_instrutor'=>$instrutor->num_licenca,'num_certificado_instrutor'=>$instrutor->num_certificado]);

            $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
            $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);


        }
        $movimentoModel = $this->calculos($movimentoModel);

        $movimentoModel->save();

    } elseif ($request->natureza == 'I' && $movimentoModel->confirmado == 0 && (($movimentoModel->piloto_id == $user->id))) {

        $piloto = User::findOrFail($request->piloto_id);

        $movimentoModel->fill($request->except(['created_at', 'updated_at']));
        $movimentoModel->num_licenca_piloto = $piloto->num_licenca;
        $movimentoModel->tipo_licenca_piloto = $piloto->tipo_licenca;
        $movimentoModel->validade_licenca_piloto = $piloto->validade_licenca;
        $movimentoModel->num_certificado_piloto = $piloto->num_certificado;
        $movimentoModel->classe_certificado_piloto = $piloto->classe_certificado;
        $movimentoModel->validade_certificado_piloto = $piloto->validade_certificado;

        $instrutor = User::findOrFail($request->instrutor_id);
        $movimentoModel->num_licenca_instrutor = $instrutor->num_licenca;
        $movimentoModel->tipo_licenca_instrutor = $instrutor->tipo_licenca;
        $movimentoModel->validade_licenca_instrutor = $instrutor->validade_licenca;
        $movimentoModel->num_certificado_instrutor = $instrutor->num_certificado;
        $movimentoModel->classe_certificado_instrutor = $instrutor->classe_certificado;
        $movimentoModel->validade_certificado_instrutor = $instrutor->validade_certificado;


        $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
        $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);

        $movimentoModel = $this->calculos($movimentoModel);
        $movimentoModel->save();


    }



        return redirect()->action('MovimentoController@index');
    }



    public function create(){

        $this->authorize('socio_DP',Auth::user()) ;

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



    public function store(MovimentoCreate $request)
    {
        $this->authorize('socio_DP',Auth::user()) ;

        $movimentos=Movimento::all();
        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
        $user= User::find(Auth::id());




    $movimento=new Movimento();

        if($request->natureza!='I' && ( ($request->piloto_id==$user->id)) ){
            $piloto=User::findOrFail($request->piloto_id);

            $movimento->fill($request->except(['created_at','updated_at','tipo_instrucao','instrutor_id','num_licenca_instrutor','validade_licenca_instrutor','tipo_licenca_instrutor','validade_licenca_instrutor','tipo_licenca_instrutor','num_certificado_instrutor','validade_certificado_instrutor','classe_certificado_instrutor']));
            $movimento->num_licenca_piloto=$piloto->num_licenca;
            $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
            $movimento->validade_licenca_piloto=$piloto->validade_licenca;
            $movimento->num_certificado_piloto=$piloto->num_certificado;
            $movimento->classe_certificado_piloto=$piloto->classe_certificado;
            $movimento->validade_certificado_piloto=$piloto->validade_certificado;

            $movimento->hora_aterragem=$this->parseDate($request->data.$request->hora_aterragem);
            $movimento->hora_descolagem=$this->parseDate($request->data.$request->hora_descolagem);


            $movimento->save();
        }elseif($request->natureza='I' && (($request->piloto_id==$user->id))){

            $piloto=User::findOrFail($request->piloto_id);

            $movimento->fill($request->except(['created_at','updated_at']));
            $movimento->num_licenca_piloto=$piloto->num_licenca;
            $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
            $movimento->validade_licenca_piloto=$piloto->validade_licenca;
            $movimento->num_certificado_piloto=$piloto->num_certificado;
            $movimento->classe_certificado_piloto=$piloto->classe_certificado;
            $movimento->validade_certificado_piloto=$piloto->validade_certificado;

            $instrutor=User::findOrFail($request->instrutor_id);
            $movimento->num_licenca_instrutor=$instrutor->num_licenca;
            $movimento->tipo_licenca_instrutor=$instrutor->tipo_licenca;
            $movimento->validade_licenca_instrutor=$instrutor->validade_licenca;
            $movimento->num_certificado_instrutor=$instrutor->num_certificado;
            $movimento->classe_certificado_instrutor=$instrutor->classe_certificado;
            $movimento->validade_certificado_instrutor=$instrutor->validade_certificado;


            $movimento->hora_aterragem=$this->parseDate($request->data.$request->hora_aterragem);
            $movimento->hora_descolagem=$this->parseDate($request->data.$request->hora_descolagem);


            $movimento->save();


        }







        /*if($request->natureza!='I' && $request->piloto_id==Auth::id()|| $request->instrutor_id==Auth::id()){
          //  $movimento=$request->except(['created_at','updated_at','tipo_conflito','justificacao_conflito']);

            $movimento=$request->except(['created_at','updated_at','tipo_instrucao','instrutor_id','num_licenca_instrutor','validade_licenca_instrutor','tipo_licenca_instrutor','validade_licenca_instrutor','tipo_licenca_instrutor','num_certificado_instrutor','validade_certificado_instrutor','classe_certificado_instrutor'])+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,
                'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado];

            $movimento["hora_aterragem"]=$this->parseDate($request->data.$request->hora_aterragem);
            $movimento["hora_descolagem"]=$this->parseDate($request->data.$request->hora_descolagem);



            /*+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'confirmado'=>'0','tipo_licenca_piloto'=>$user->tipo_licenca
                    ,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado,
                    'numero_linceca_instrutor'=>$instrutor->num_licenca,'validade_licenca_instrutor'=>$instrutor->validade_licenca,'tipo_licenca_instrutor'=>$instrutor->tipo_licenca,
                    'validade_certificado_instrutor'=>$instrutor->validade_certificado,'classe_certificado_instrutor'=>$instrutor->classe_certificado,'num_licenca_instrutor'=>$instrutor->num_licenca,
                    'num_certificado_instrutor'=>$instrutor->num_certificado];


            $movimento=Movimento::create($movimento);


        }*/

    /*   {{--  if($request->natureza=='I' && $request->piloto_id==Auth::id()|| $request->instrutor_id==Auth::id()){

            $movimento=$request->except('created_at', 'updated_at')+['num_licenca_piloto'=>$user->num_licenca,'validade_licenca_piloto'=>$user->validade_licenca,'tipo_licenca_piloto'=>$user->tipo_licenca
                    ,'num_certificado_piloto'=>$user->num_certificado,'validade_certificado_piloto'=>$user->validade_licenca,'classe_certificado_piloto'=>$user->classe_certificado,
                    'numero_linceca_instrutor'=>$instrutor->num_licenca,'validade_licenca_instrutor'=>$instrutor->validade_licenca,'tipo_licenca_instrutor'=>$instrutor->tipo_licenca,
                    'validade_certificado_instrutor'=>$instrutor->validade_certificado,'classe_certificado_instrutor'=>$instrutor->classe_certificado,'num_licenca_instrutor'=>$instrutor->num_licenca,
                    'num_certificado_instrutor'=>$instrutor->num_certificado];


            $movimento["hora_aterragem"]=$this->parseDate($request->data.$request->hora_aterragem);
            $movimento["hora_descolagem"]=$this->parseDate($request->data.$request->hora_descolagem);

            $movimento=Movimento::create($movimento);

        }*/







        return redirect()->action('MovimentoController@index');
    }






    public function destroy($id){
        $movimento= Movimento::findOrFail($id);
        $user= User::findOrFail(Auth::id());
        if(($movimento->piloto_id==Auth::id()|| $user->direcao) && $movimento->confirmado==0 ){

            $movimento->delete();

        }



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

    public function calculos($movimento){
        $valor=($movimento->conta_horas_fim)-($movimento->conta_horas_inicio);
        $horas=(integer)$valor/10;
        $unidades= $valor%10;
        if($unidades!=0){
            $minutos= DB::table('aeronaves_valores')->select('minutos')->where('matricula',$movimento->aeronave)->where('unidade_conta_horas', $unidades)->value('minutos');
            $preco = DB::table('aeronaves_valores')->select('preco')->where('matricula',$movimento->aeronave)->where('unidade_conta_horas',$unidades )->first()->preco;
        }
        $minutos += 60*(integer)$horas;
        $preco_hora=DB::table('aeronaves')->select('preco_hora')->where('matricula',$movimento->matricula)->value('preco_hora');
        $preco += (integer)$horas*$preco_hora;
        $movimento->preco_voo = $preco;
        $movimento->tempo_voo = $minutos;

        return $movimento;
    }






}
