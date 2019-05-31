<?php

namespace App\Http\Controllers;
use App\Aeronave;
use App\AeronavePilotos;
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
        $confirmarVarios=request()->query('confirmarVarios');
        if(!$confirmarVarios){
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


            }


        $aeronaves=Aeronave::all();
        $pressed=request()->query('movimentos');
        //meus movimentos


        if(!is_null($confirmarVarios) && $confirmarVarios=="true"){
            dd(request()->all());
            if(!is_null($checkboxConfirmado)){
                foreach ($checkboxConfirmado as $checked) {
                    $movimento= Movimento::findOrFail($checked);
                    $movimento->tipo_conflito=null;
                    foreach($aeronaves as $aeronave){
                        if($aeronave->matricula=$movimento->aeronave){
                            $aeronave2=Aeronave::findOrFail($movimento->aeronave);
                            $aeronave2->conta_horas+= $movimento->conta_horas_fim-$movimento->conta_horas_inicio;
                                $aeronave2->save();
                        }
                    }

                    $movimento->confirmado="1";
                    $movimento->tipo_conflito=null;
                    $movimento->justificacao_conflito=null;
                    //conflitos
                    $movimento->save();
                }

            }

        }



        if(Auth::user()->can('socio_piloto', Auth::user())){
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
                'aeronave'=>request('aeronave'),
                'natureza'=>request('natureza'),
                'data_inf'=>request('data_inf'),
                'data_sup'=>request('data_sup'),


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
                    'aeronave'=>request('aeronave'),
                    'natureza'=>request('natureza'),
                    'data_inf'=>request('data_inf'),
                    'data_sup'=>request('data_sup'),

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
        $movimento= Movimento::findOrFail($id);
        $this->authorize('update', $movimento ) ;


        $title = "Editar movimentos ";


        $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();



          foreach ($aeronaves as $aeronave) {
            $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
        }




        if(Auth::user()->direcao==1 || $movimento->piloto_id== Auth::id() || $movimento->instrutor_id==Auth::id() ){
            return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores'));
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





        $movimentoModel= Movimento::findOrFail($id);


      
       
             //    dd($request->conta_horas_inicio != $movimentoModel->conta_horas_inicio || $request->conta_horas_fim != $movimentoModel->conta_horas_fim);




        $this->authorize('update', $movimentoModel ) ;








        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }

          


               if ($request->has('confirmar')) {
            $movimentoModel->confirmado=1;
            $movimentoModel->tipo_conflito=null;
            $movimentoModel->justificacao_conflito=null;
            $movimentoModel->save();
            return redirect()->action('MovimentoController@index');
        }




        $movimentos=Movimento::all();


   







        $contaHorasInicial=$request->conta_horas_inicio;
        $contaHorasFinal=$request->conta_horas_fim;





         $aeronaves=Aeronave::all();
        $socios=User::all();
        $aerodromos=Aerodromo::all();
        $user=User::findOrFail(Auth::id());







        












        if($user->direcao==0) {
            if(Auth::id()==$movimentoModel->piloto_id){
            if ($request->natureza != 'I' && $movimentoModel->confirmado == 0) {
                if (($request->piloto_id == $movimentoModel->piloto_id) == Auth::id() ) {
                    //  $movimentoModel->fill($request->except('tipo_conflito','justificacao_conflito','updated_at','created_at','classe_certificado_instrutor','validade_certificado_instrutor','num_certificado_instrutor','tipo_licenca_instrutor','validade_licenca_instrutor', 'num_licenca_instrutor', 'instrutor_id','tipo_instrucao', 'classe_licenca_piloto'));
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
                        dd($movimentoModel);
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
               
            

                }
            }







              //O gajo nao é autorizado nesta aeronave
/*
        $aeronavesPilotos=AeronavePilotos::all()->where('matricula',$request->aeronave)->where('piloto_id',$request->piloto_id);

        if(!is_null($request->instrutor_id)){
         $aeronavesInstrutor=AeronavePilotos::all()->where('matricula',$request->aeronave)->where('piloto_id',$request->instrutor_id);
}



     
         $pilotoAutorizado=isset($aeronavesPilotos[0]->id);
          $instrutorAutorizado=isset($aeronavesInstrutor[0]->id);

          if(!$pilotoAutorizado || !$instrutorAutorizado){

       
                $movimento=$movimentoModel; 
                $valores[]=Aeronave::findOrFail($movimento->aeronave)->aeronaveValores()->get()->toArray();

                if(!$pilotoAutorizado){
                $pilotoErrado="Piloto Invalido.Nao tem acesso a Aeronave";
                }

                if(isset($aeronavesInstrutor)&&!$instrutorAutorizado){
                $instrutorErrado="instrutor Invalido.Nao tem acesso a Aeronave";
            }

                $title="Editar movimentos";
             

                if(!$pilotoAutorizado && isset($aeronavesInstrutor)&&!$instrutorAutorizado){

                return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores','instrutorErrado','pilotoErrado'));

            }

            if(!$pilotoAutorizado){
                   return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores','pilotoErrado'));
            }



            if(isset($aeronavesInstrutor)&&!$instrutorAutorizado){
                  return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores','instrutorErrado'));
            }


            
          }


     

*/
   















                    $movimento=new Movimento();
                    $movimento=$movimentoModel;









 

            //podia ter feito uma funcao a ver se tinha conflito
           

          if($request->has('comConflitos') ) {       //&& $movAlterado->conta_horas_inicio!=$request->query('conta_horas_inicio') || $movAlterado->conta_horas_fim!=$request->query('conta_horas_fim') adicioanr para ver se ele alterou alguma coisa do conta horas se nao quero correr verificacoes de nvo
    
          $textConflito=$request->razaoConflito;

        
          if($request->tipo_conflito=="S"){
           $movimento->tipo_conflito="S";
            $movimento->justificacao_conflito=$request->justificacao_conflito;
         
           $movimento->save();




            foreach ($movimentos as $m) {
                foreach ($aeronaves as $aeronave) {
                    # code...
                if($m->aeronave == $aeronave->matricula){//podia ser so com os movimentos so fazeiamos com que nao fosse == ao id do actual
                if(($m->conta_horas_inicio<=$contaHorasInicial)  && ($m->conta_horas_fim >= $contaHorasFinal) && $m->confirmado!="1"){ // faltam validaçoes se estiver

                $m->tipo_conflito="S";
                $m->save();
                           
              }
            }
        }
    }



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
                if($m->matricula==$movimento->matricula){
                if(($m->conta_horas_inicio<$contaHorasInicial)  && ($m->conta_horas_fim > $contaHorasFinal)){ // faltam validaçoes se estiver a meio cenas desse genero
            
                
                $valores[]=Aeronave::findOrFail($movimento->aeronave)->aeronaveValores()->get()->toArray();
            
                $title="Conflito sobreposicao";
                # code...
                //sobreposicao
            


                    $tipo_conflito="S";

                    $hora_inicio=$request->hora_aterragem;
                    $hora_fim=$request->hora_aterragem;
                 return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores','tipo_conflito'));
                         }
              }
       



              if( $m->id != $movimento->id && $m->conta_horas_fim==$contaHorasInicial ){
             
                    //se por acaso tivesse conflito passava para null passa primeiro por sobreposicao por isso nao ha problena 
                $aux=1;//encontrado o conta kilometros final
             
              }

              if($contaHorasFinal==$m->contaHorasInicial){
                    if($m->tipo_conflito=="B"){
                        $m->tipo_conflito=null;

                        //nao sei se necessario por a jsutificacao a 0
                    }


              }
            }
       


            if($aux==0){
            foreach ($aeronaves as $aeronave) {
            $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
            }
              //buraco

                 $hora_inicio=$request->hora_aterragem;
                 $hora_fim=$request->hora_descolagem;  
                   $tipo_conflito="B";
              
                 $title="Conflito Buraco Temporal ";
                 $conflito="B";
                   return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios','aerodromos','valores','tipo_conflito'));
          }










      














































              $movimentoModel->save();















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



        return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','valores'));
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

                $movimento->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                $movimento->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);
      

                 $movimento = $this->calculos($movimento);
      


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

                $movimento->hora_aterragem = $this->parseDate($request->data . $request->hora_aterragem);
                $movimento->hora_descolagem = $this->parseDate($request->data . $request->hora_descolagem);

                       $movimento = $this->calculos($movimento);
             

            }
        }


 

            //podia ter feito uma funcao a ver se tinha conflito


          if($request->has('comConflitos')){       //&& $movAlterado->conta_horas_inicio!=$request->query('conta_horas_inicio') || $movAlterado->conta_horas_fim!=$request->query('conta_horas_fim') adicioanr para ver se ele alterou alguma coisa do conta horas se nao quero correr verificacoes de nvo
    
          $textConflito=$request->razaoConflito;

        
          if($request->title=="S"){
           $movimento->tipo_conflito="S";
            $movimento->justificacao_conflito=$request->justificacao_conflito;
         
           $movimento->save();




            foreach ($movimentos as $m) {
                foreach ($aeronaves as $aeronave) {
                    # code...
                if($m->aeronave == $aeronave->matricula){
                if(($m->conta_horas_inicio<=$contaHorasInicial)  && ($m->conta_horas_fim >= $contaHorasFinal) && $m->confirmado!="1"){ // faltam validaçoes se estiver a meio cenas desse genero
                $m->tipo_conflito="S";
                           
              }
            }
        }
    }



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
                if($m->matricula==$movimento->matricula){
                if(($m->conta_horas_inicio<=$contaHorasInicial)  && ($m->conta_horas_fim >= $contaHorasFinal)){ // faltam validaçoes se estiver a meio cenas desse genero
            
                
                $valores[]=Aeronave::findOrFail($movimento->aeronave)->aeronaveValores()->get()->toArray();
            
                $title="Conflito sobreposicao";
                # code...
                //sobreposicao
            


                    $conflito="S";

                    $hora_inicio=$request->hora_aterragem;
                    $hora_fim=$request->hora_aterragem;

                   return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','movimentos','valores','conflito','movimento','hora_inicio','hora_fim'));
                         }
              }
       



              if( $m->conta_horas_fim==$contaHorasInicial){
             
                    //se por acaso tivesse conflito passava para null passa primeiro por sobreposicao por isso nao ha problena 
                $aux=1;//encontrado o conta kilometros final
             
              }

              if($contaHorasFinal==$m->contaHorasInicial){
                    if($m->tipo_conflito=="B"){
                        $m->tipo_conflito=null;
                    }


              }
            }
       


            if($aux==0){
            foreach ($aeronaves as $aeronave) {
            $valores[]=Aeronave::findOrFail($aeronave->matricula)->aeronaveValores()->get()->toArray();
            }
              //buraco

                 $hora_inicio=$request->hora_aterragem;
                 $hora_fim=$request->hora_descolagem;  

             
                 $title="Conflito Buraco Temporal ";
                 $conflito="B";
                return view('movimentos.create',compact('title','aeronaves','socios','aerodromos','movimentos','valores','conflito','movimento','hora_inicio','hora_fim'));
          }




          //sem conflitos
           $movimento->save();


        return redirect()->action('MovimentoController@index');
    }






    public function destroy($id){
        $movimento= Movimento::findOrFail($id);
        $user= User::findOrFail(Auth::id());
        $movimentos=Movimento::all();
        $contaHorasInicial=$movimento->conta_horas_inicio;
        $contaHorasFinal=$movimento->conta_horas_fim;



        if(($movimento->piloto_id==Auth::id()|| $user->direcao) && $movimento->confirmado==0 ){

            if($movimento->tipo_conflito=='S'){
                foreach ($movimentos as $m) {
                    # code...
                    if($movimento->aeronave == $m->aeronave){
                      if(($m->conta_horas_inicio<$contaHorasInicial)  && ($m->conta_horas_fim > $contaHorasFinal)){ 
                        $m->tipo_conflito=null; //limpar a sobreposicao problema se houver 3 fazer outro for? fiz  como se fossem 2 conflitos tem problemas
                        $m->tipo_conflito=null;
                      }
                  }

                }
            }


            $movimento->delete();

        }



        return redirect()->action('MovimentoController@index');

    }


















    public function mostrarEstatisticas(){
        $chart = null;
        $nome = request()->Nome;
        $eixoX = request()->eixoX;
        $eixoY = request()->eixoY;


        $datas_ano = \DB::table('movimentos')
            ->select(\DB::raw('distinct DATE_FORMAT(data,"%Y") as date'))
            ->orderByRaw('date asc')->get();

        $datas_mes = \DB::table('movimentos')
            ->select(\DB::raw('distinct DATE_FORMAT(data,"%Y/%m") as date'))
            ->orderByRaw('date asc')->get();

        //aeronave mes

        $aux = array(array(), array());

        $aeronaves = \DB::table('movimentos')
            ->select(\DB::raw('distinct aeronave'))
            ->orderByRaw('aeronave asc')->get()->toArray();

        $i = 0;
        foreach ($aeronaves as $aeronave) {
            $movimentosAMes[$i] = array(0 => $aeronave->aeronave);
            $i++;
        }

        $aux_movimentos = \DB::table('movimentos')
            ->select(\DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%Y") as date, aeronave'))
            ->groupBy('date', 'aeronave')
            ->orderByRaw('aeronave asc, date asc')->get();


        $i=0;
        foreach ($aux_movimentos as $movimento) {
            foreach ($movimentosAMes as $aux) {
                if($aux[0] == $movimento->aeronave) {
                    break;
                }
                $i++;
            }
            $movimentosAMes[$i] += [$movimento->date => $movimento->Total_Flight_Hours];
            $i=0;
        }
        //aeronave ano

        $aux = array(array(), array());

        $aeronaves = \DB::table('movimentos')
            ->select(\DB::raw('distinct aeronave'))
            ->orderByRaw('aeronave asc')->get()->toArray();

        $i = 0;
        foreach ($aeronaves as $aeronave) {
            $movimentosAAno[$i] = array(0 => $aeronave->aeronave);
            $i++;
        }

        $aux_movimentos = \DB::table('movimentos')
            ->select(\DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%Y") as date, aeronave'))
            ->groupBy('date', 'aeronave')
            ->orderByRaw('aeronave asc, date asc')->get();

        $i=0;
        foreach ($aux_movimentos as $movimento) {
            foreach ($movimentosAAno as $aux) {
                if($aux[0] == $movimento->aeronave) {
                    break;
                }
                $i++;
            }
            $movimentosAAno[$i] += [$movimento->date => $movimento->Total_Flight_Hours];
            $i=0;
        }


        //mes piloto

        $aux = array(array(), array());

        $pilotos_ids = \DB::table('movimentos')
            ->select(\DB::raw('distinct piloto_id'))
            ->orderByRaw('piloto_id asc')->get()->toArray();

        $i = 0;
        foreach ($pilotos_ids as $id) {
            $movimentosPMes[$i] = array(0 => $id->piloto_id);
            $i++;
        }

        $aux_movimentos = \DB::table('movimentos')
            ->select(\DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%Y/%m") as date, piloto_id'))
            ->groupBy('date', 'piloto_id')
            ->orderByRaw('piloto_id asc, date asc')->get();

        $i=0;
        foreach ($aux_movimentos as $movimento) {
            foreach ($movimentosPMes as $aux) {
                if($aux[0] == $movimento->piloto_id) {
                    break;
                }
                $i++;
            }
            $movimentosPMes[$i] += [$movimento->date => $movimento->Total_Flight_Hours];
            $i=0;
        }

        //ano piloto

        $aux = array(array(), array());

        $pilotos_ids = \DB::table('movimentos')
            ->select(\DB::raw('distinct piloto_id'))
            ->orderByRaw('piloto_id asc')->get()->toArray();

        $i = 0;
        foreach ($pilotos_ids as $id) {
            $movimentosPAno[$i] = array(0 => $id->piloto_id);
            $i++;
        }

        $aux_movimentos = \DB::table('movimentos')
            ->select(\DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%Y") as date, piloto_id'))
            ->groupBy('date', 'piloto_id')
            ->orderByRaw('piloto_id asc, date asc')->get();

        $i=0;
        foreach ($aux_movimentos as $movimento) {
            foreach ($movimentosPAno as $aux) {
                if($aux[0] == $movimento->piloto_id) {
                    break;
                }
                $i++;
            }
            $movimentosPAno[$i] += [$movimento->date => $movimento->Total_Flight_Hours];
            $i=0;
        }

        $title="";
        if($nome == null && $eixoY == null && $eixoX == null){
            return view('movimentos.estatisticas', compact('title','chart', 'movimentosAAno','movimentosAMes', 'movimentosPAno' ,  'movimentosPMes', 'datas_ano', 'datas_mes'));
        }

        $chart = $this->estatisticas($nome, $eixoX, $eixoY);

        return view('movimentos.estatisticas', compact('title','chart', 'movimentosAAno', 'movimentosPAno', 'movimentosAMes', 'movimentosPMes', 'datas_ano', 'datas_mes'));

    }


    public function estatisticas($nome, $eixoX, $eixoY){

        //query para ir buscar os dados que preciso para fazer o grafico
        $query_chart=DB::table('movimentos');
        if(strcmp($eixoX, "Ano") == 0){
            $query_chart = $query_chart->select(DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%Y") as date'));
        }
        if(strcmp($eixoX, "Mes") == 0){
            $query_chart = $query_chart->select(DB::raw('sum(TIMESTAMPDIFF(MINUTE, hora_descolagem, hora_aterragem)/60) as "Total_Flight_Hours", DATE_FORMAT(data,"%m/%Y") as date'));
        }
        if(strcmp($eixoY, "Piloto") == 0){
            $id_piloto = "";
            $user=User::where('nome_informal', 'like', $nome)->first();
            if($user != null){
                $id_piloto .= $user->id;
            }

            $query_chart = $query_chart->where('piloto_id', $id_piloto);
        }
        if(strcmp($eixoX, "Aeronave") == 0){
            $query_chart = $query_chart->where('aeronave', 'like', $nome);
        }
        $query_chart = $query_chart->groupBy('data')->get();


        $chart = Charts::create('line', 'highcharts')
            ->title("Total de horas por ". $eixoX . "/" . $eixoY . " (" . $nome . ")")
            ->elementLabel("Total Flight Hours")
            ->labels($query_chart->pluck('date'))
            ->values($query_chart->pluck('Total_Flight_Hours'))
            ->dimensions(1000,500)
            ->responsive(true);

        return $chart;
    }

    public function calculos($movimento){
        

        $minutos=0;
        $preco=0;

        $valor=($movimento->conta_horas_fim)-($movimento->conta_horas_inicio);
        $horas=(integer)$valor/10;
        
        $unidades= $valor%10;
        

        if($unidades!=0){
            $minutos= DB::table('aeronaves_valores')->select('minutos')->where('matricula',$movimento->aeronave)->where('unidade_conta_horas', $unidades)->value('minutos');
            $preco = DB::table('aeronaves_valores')->select('preco')->where('matricula',$movimento->aeronave)->where('unidade_conta_horas',$unidades)->first()->preco;
        }
        $minutos += 60*(integer)$horas;
        $preco_hora=DB::table('aeronaves')->select('preco_hora')->where('matricula',$movimento->aeronave)->value('preco_hora');
        $preco += (integer)$horas*$preco_hora;
        $movimento->preco_voo = $preco;
        $movimento->tempo_voo = $minutos;
         
        return $movimento;
    }









}
