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

        $this->authorize('socio_DP', Auth::user() ) ;


        $title = "Editar movimentos ";
        $movimento= Movimento::findOrFail($id);

        $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();

        if(Auth::user()->direcao==1 || $movimento->piloto_id== Auth::id() || $movimento->instrutor_id==Auth::id() ){
            return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos'));
        }
        else{

            return redirect()->action('MovimentoController@index');
        }



    }


    public function parseDate($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i:s');
    }



    public function update(MovimentoUpdate $request, $id){


        $this->authorize('socio_DP', Auth::user() ) ;


        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }


        $movimentoModel= Movimento::findOrFail($id);
        $user=User::findOrFail(Auth::id());


        if($user->direcao==0) {
            if(Auth::id()==$movimentoModel->piloto_id ) {
            if ($request->natureza != 'I' && $movimentoModel->confirmado == 0) {
                if (($request->piloto_id == $movimentoModel->piloto_id) == Auth::id() ) {

                    //  $movimentoModel->fill($request->except('tipo_conflito','justificacao_conflito','updated_at','created_at','classe_certificado_instrutor','validade_certificado_instrutor','num_certificado_instrutor','tipo_licenca_instrutor','validade_licenca_instrutor', 'num_licenca_instrutor', 'instrutor_id','tipo_instrucao', 'classe_licenca_piloto' ));
                    $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                    $piloto = User::findOrFail($request->piloto_id);
                    $movimentoModel->num_licenca_piloto = $piloto->num_licenca;
                    $movimentoModel->tipo_licenca_piloto = $piloto->tipo_licenca;
                    $movimentoModel->validade_licenca_piloto = $piloto->validade_licenca;
                    $movimentoModel->num_certificado_piloto = $piloto->num_certificado;
                    $movimentoModel->classe_certificado_piloto = $piloto->classe_certificado;
                    $movimentoModel->validade_certificado_piloto = $piloto->validade_certificado;
                    $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                    $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);
                    $movimentoModel = $this->calculos($movimentoModel);

                    $movimentoModel->save();

                    }
                }

            }
              if(Auth::id()==$movimentoModel->piloto_id || Auth::id()==$movimentoModel->instrutor_id) {
                  if (($request->natureza == 'I' && $movimentoModel->confirmado == 0)) {
                      if ($request->piloto_id  == Auth::id() || $request->instrutor_id  == Auth::id()) {

                          $piloto = User::findOrFail($request->piloto_id);
                          $movimentoModel->fill($request->all());
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
                  }
              }
        }


        if($user->direcao==1) {
            if ($request->natureza != 'I' && $movimentoModel->confirmado == 0) {
                $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                if ($movimentoModel->piloto_id != $request->piloto_id) {
                    $newPilot = User::findOrFail($request->piloto_id);
                    $movimentoModel->num_licenca_piloto = $newPilot->num_licenca;
                    $movimentoModel->tipo_licenca_piloto = $newPilot->tipo_licenca;
                    $movimentoModel->validade_licenca_piloto = $newPilot->validade_licenca;
                    $movimentoModel->num_certificado_piloto = $newPilot->num_certificado;
                    $movimentoModel->classe_certificado_piloto = $newPilot->classe_certificado;
                    $movimentoModel->validade_certificado_piloto = $newPilot->validade_certificado;
                } else {

                    $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                }

                $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);
                $movimentoModel = $this->calculos($movimentoModel);

                $movimentoModel->save();
            }

                if (($request->natureza == 'I' && $movimentoModel->confirmado == 0)) {

                    $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                    if ($movimentoModel->piloto_id != $request->piloto_id) {
                        $piloto = User::findOrFail($request->piloto_id);
                        $movimentoModel->num_licenca_piloto = $piloto->num_licenca;
                        $movimentoModel->tipo_licenca_piloto = $piloto->tipo_licenca;
                        $movimentoModel->validade_licenca_piloto = $piloto->validade_licenca;
                        $movimentoModel->num_certificado_piloto = $piloto->num_certificado;
                        $movimentoModel->classe_certificado_piloto = $piloto->classe_certificado;
                        $movimentoModel->validade_certificado_piloto = $piloto->validade_certificado;

                    }
                    if ($movimentoModel->instrutor_id != $request->instrutor_id) {
                        $instrutor = User::findOrFail($request->instrutor_id);
                        $movimentoModel->num_licenca_instrutor = $instrutor->num_licenca;
                        $movimentoModel->tipo_licenca_instrutor = $instrutor->tipo_licenca;
                        $movimentoModel->validade_licenca_instrutor = $instrutor->validade_licenca;
                        $movimentoModel->num_certificado_instrutor = $instrutor->num_certificado;
                        $movimentoModel->classe_certificado_instrutor = $instrutor->classe_certificado;
                        $movimentoModel->validade_certificado_instrutor = $instrutor->validade_certificado;
                    }

                    $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                    $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);

                    $movimentoModel = $this->calculos($movimentoModel);
                    $movimentoModel->save();

                }
            }







//se for direcao pode fazer tudo
        //se for piloto tem que ser os  seus movimentos...
  /*  if ($request->natureza != 'I' && $movimentoModel->confirmado == 0) {
        if(Auth::user()->direcao==1){
            $movimentoModel->fill($request->except(['created_at', 'updated_at']));
            if($movimentoModel->piloto_id!=$request->piloto_id){
                $newPilot = User::findOrFail($request->piloto_id);
                $movimentoModel->num_licenca_piloto = $newPilot->num_licenca;
                $movimentoModel->tipo_licenca_piloto = $newPilot->tipo_licenca;
                $movimentoModel->validade_licenca_piloto = $newPilot->validade_licenca;
                $movimentoModel->num_certificado_piloto = $newPilot->num_certificado;
                $movimentoModel->classe_certificado_piloto = $newPilot->classe_certificado;
                $movimentoModel->validade_certificado_piloto = $newPilot->validade_certificado;
            }
            else{
                $movimentoModel->fill($request->except(['created_at', 'updated_at']));

            }

            $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
            $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);
            $movimentoModel = $this->calculos($movimentoModel);

            $movimentoModel->save();

        }else{
            if($movimentoModel->piloto_id==$request->piloto_id || $movimentoModel->instrutor_id==$request->piloto_id ){
                $movimentoModel->fill($request->except(['created_at', 'updated_at']));

            }

            $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
            $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);
            $movimentoModel = $this->calculos($movimentoModel);

            $movimentoModel->save();
        }


    }

    if ($request->natureza == 'I' && $movimentoModel->confirmado == 0  ){
        if(Auth::user()->direcao==1){
            $movimentoModel->fill($request->except(['created_at', 'updated_at']));
            if($movimentoModel->piloto_id!=$request->piloto_id){
                $piloto = User::findOrFail($request->piloto_id);
                $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                $movimentoModel->num_licenca_piloto = $piloto->num_licenca;
                $movimentoModel->tipo_licenca_piloto = $piloto->tipo_licenca;
                $movimentoModel->validade_licenca_piloto = $piloto->validade_licenca;
                $movimentoModel->num_certificado_piloto = $piloto->num_certificado;
                $movimentoModel->classe_certificado_piloto = $piloto->classe_certificado;
                $movimentoModel->validade_certificado_piloto = $piloto->validade_certificado;

            }
            if($movimentoModel->instrutor_id!=$request->instrutor_id){
                $instrutor = User::findOrFail($request->instrutor_id);
                $movimentoModel->num_licenca_instrutor = $instrutor->num_licenca;
                $movimentoModel->tipo_licenca_instrutor = $instrutor->tipo_licenca;
                $movimentoModel->validade_licenca_instrutor = $instrutor->validade_licenca;
                $movimentoModel->num_certificado_instrutor = $instrutor->num_certificado;
                $movimentoModel->classe_certificado_instrutor = $instrutor->classe_certificado;
                $movimentoModel->validade_certificado_instrutor = $instrutor->validade_certificado;
            }


                $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);



            $movimentoModel = $this->calculos($movimentoModel);
            $movimentoModel->save();
        }

        if(Auth::id()==$movimentoModel->piloto_id || Auth::id()==$movimentoModel->instrutor_id){
                if($movimentoModel->piloto_id==$request->piloto_id || $movimentoModel->instrutor_id==$request->instrutor_id ){
                    $movimentoModel->fill($request->except(['created_at', 'updated_at']));
                    if($movimentoModel->piloto_id!=$request->piloto_id){
                        $piloto = User::findOrFail($request->piloto_id);

                        $movimentoModel->num_licenca_piloto = $piloto->num_licenca;
                        $movimentoModel->tipo_licenca_piloto = $piloto->tipo_licenca;
                        $movimentoModel->validade_licenca_piloto = $piloto->validade_licenca;
                        $movimentoModel->num_certificado_piloto = $piloto->num_certificado;
                        $movimentoModel->classe_certificado_piloto = $piloto->classe_certificado;
                        $movimentoModel->validade_certificado_piloto = $piloto->validade_certificado;

                    }


                    if($movimentoModel->instrucao_id!=$request->instrucao_id){
                        $instrutor = User::findOrFail($request->instrutor_id);
                        $movimentoModel->num_licenca_instrutor = $instrutor->num_licenca;
                        $movimentoModel->tipo_licenca_instrutor = $instrutor->tipo_licenca;
                        $movimentoModel->validade_licenca_instrutor = $instrutor->validade_licenca;
                        $movimentoModel->num_certificado_instrutor = $instrutor->num_certificado;
                        $movimentoModel->classe_certificado_instrutor = $instrutor->classe_certificado;
                        $movimentoModel->validade_certificado_instrutor = $instrutor->validade_certificado;
                    }
                    $movimentoModel->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                    $movimentoModel->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);

                    $movimentoModel = $this->calculos($movimentoModel);
                    $movimentoModel->save();
                }


            }

        }
*/










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
       $user= User::find($request->piloto_id);
        $instrutor=User::find($request->instrutor_id);
        $contaHorasInicial=$request->conta_horas_inicio;
        $contaHorasFinal=$request->conta_horas_fim;
        $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();






    $movimento=new Movimento();//nao usei o create pq nao quero gravar na base de dados


   $movimento->confirmado=0;


















        if($request->natureza!='I'){

            if( ($request->piloto_id==Auth::id()) || ($request->instrutor_id==Auth::id() ) || (Auth::user()->direcao==1)  )  {
                $piloto = User::findOrFail($request->piloto_id);

                $movimento->fill($request->except(['created_at', 'updated_at', 'tipo_instrucao', 'instrutor_id', 'num_licenca_instrutor', 'validade_licenca_instrutor', 'tipo_licenca_instrutor', 'validade_licenca_instrutor', 'tipo_licenca_instrutor', 'num_certificado_instrutor', 'validade_certificado_instrutor', 'classe_certificado_instrutor']));
                $movimento->num_licenca_piloto = $piloto->num_licenca;
                $movimento->tipo_licenca_piloto = $piloto->tipo_licenca;
                $movimento->validade_licenca_piloto = $piloto->validade_licenca;
                $movimento->num_certificado_piloto = $piloto->num_certificado;
                $movimento->classe_certificado_piloto = $piloto->classe_certificado;
                $movimento->validade_certificado_piloto = $piloto->validade_certificado;
                 $movimento->hora_aterragem=$request->hora_aterragem;
                 $movimento->hora_descolagem=$request->hora_descolagem;

                //$movimento->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
               // $movimento->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);

            }
        }

















        if($request->natureza=='I' ){
            if( ($request->piloto_id==Auth::id()) || ($request->instrutor_id==Auth::id()) || (Auth::user()->direcao==1)) {

                $piloto = User::findOrFail($request->piloto_id);

                $movimento->fill($request->except(['created_at', 'updated_at']));
                $movimento->num_licenca_piloto = $piloto->num_licenca;
                $movimento->tipo_licenca_piloto = $piloto->tipo_licenca;
                $movimento->validade_licenca_piloto = $piloto->validade_licenca;
                $movimento->num_certificado_piloto = $piloto->num_certificado;
                $movimento->classe_certificado_piloto = $piloto->classe_certificado;
                $movimento->validade_certificado_piloto = $piloto->validade_certificado;

                $instrutor = User::findOrFail($request->instrutor_id);
                $movimento->num_licenca_instrutor = $instrutor->num_licenca;
                $movimento->tipo_licenca_instrutor = $instrutor->tipo_licenca;
                $movimento->validade_licenca_instrutor = $instrutor->validade_licenca;
                $movimento->num_certificado_instrutor = $instrutor->num_certificado;
                $movimento->classe_certificado_instrutor = $instrutor->classe_certificado;
                $movimento->validade_certificado_instrutor = $instrutor->validade_certificado;

                //$movimento->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                //$movimento->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);


             

            }
        }





            //podia ter feito uma funcao a ver se tinha conflito


          if($request->has('comConflitos')){       //&& $movAlterado->conta_horas_inicio!=$request->query('conta_horas_inicio') || $movAlterado->conta_horas_fim!=$request->query('conta_horas_fim') adicioanr para ver se ele alterou alguma coisa do conta horas se nao quero correr verificacoes de nvo
    
          $textConflito=$request->razaoConflito;

        
          if($request->title=="S"){
           $movimento->tipo_conflito="S";
            $movimento->justificacao_conflito=$request->justificacao_conflito;
         
           $movimento->save();

             return redirect()->action('MovimentoController@index');
          }else{
             $movimento->tipo_conflito="B";
            $movimento->justificacao_conflito=$request->justificacao_conflito;
               $movimento->save();
             return redirect()->action('MovimentoController@index');
          }
          
        }



              $aux=0; 
              foreach ($movimentos as $m) {
                foreach ($aeronaves as $aeronave) {
                    # code...
                if($m->aeronave == $aeronave->matricula){
                if(($m->conta_horas_inicio<=$contaHorasInicial)  && ($m->conta_horas_fim >= $contaHorasFinal)){ // faltam validaçoes se estiver a meio cenas desse genero
            
        
                $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
          
                $title="Conflito sobreposicao";
                # code...
                  //sobreposicao
               $conflito="S";
                   return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','movimentos','valores','conflito','movimento'));
                         }
              }
          }



              if( $m->conta_horas_fim==$contaHorasInicial){
          
                $aux=1;//encontrado o conta kilometros final
             
              }
            }
       
            if(!is_null($m->conta_horas_fim)&&$aux==0){
            foreach ($aeronaves as $aeronave) {
            $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
            }
              //buraco
                 $title="Conflito Buraco Temporal blalblalbla coisa parecida";
                 $conflito="B";
                return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','movimentos','valores','conflito','movimento'));
          }





           $movimento->save();


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
