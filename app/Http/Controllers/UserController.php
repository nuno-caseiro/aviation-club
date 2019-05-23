<?php

namespace App\Http\Controllers;


use App\ClassesCertificados;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;

use App\Movimento;
use App\TiposLicencas;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePassword;
use Illuminate\Support\Facades\Auth;
use Hash;
use DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        //$users= new \stdClass();
        $this->authorize('listar', Auth::user());


         if(Auth::user()->can('socio_Direcao', Auth::user())){
             $num_socio=request()->query('num_socio');
             $nome_informal=request()->query('nome_informal');
             $email=request()->query('email');
             $tipo=request()->query('tipo');
             $direcao=request()->query('direcao');
             $quotas_pagas=request()->query('quotas_pagas');
             $ativo=request()->query('ativo');
             $filtro = User::where('ativo','>=','0');

             if (isset($num_socio)) {
                 $filtro = $filtro->where('num_socio', $num_socio);
             }
             if (isset($nome_informal)) {
                 $filtro = $filtro->where('nome_informal', 'like','%'.$nome_informal.'%');
             }
             if (isset($email)) {
                 $filtro = $filtro->where('email', 'like','%'.$email.'%');
             }
             if (isset($tipo)) {
                 $filtro = $filtro->where('tipo_socio', $tipo);
             }
             if (isset($direcao)) {
                 $filtro = $filtro->where('direcao', $direcao);
             }
             if(isset($quotas_pagas)){
                 $filtro=$filtro->where('quota_paga',$quotas_pagas);
             }
             if(isset($ativo)){
                 $filtro=$filtro->where('ativo',$ativo);
             }


                 $users =$filtro->paginate(20)->appends([
                     'num_socio' => request('num_socio'),
                     'nome_informal' => request('nome_informal'),
                     'email' => request('email'),
                     'tipo' => request('tipo'),
                     'direcao' => request('direcao'),
                     'quotas_pagas' => request('quotas_pagas'),
                     'ativo' => request('ativo'),
                     'num_licenca' =>request('num_licenca'),

                 ]);






        }elseif(Auth::user()->can('socio_normal', Auth::user())) {
             //$users = User::where('ativo', '=', '1')->paginate(15);


             $num_socio = request()->query('num_socio');
             $nome_informal = request()->query('nome_informal');
             $email = request()->query('email');
             $tipo = request()->query('tipo');
             $direcao = request()->query('direcao');
             // $filtro=  DB::table('users')->select(['num_socio', 'nome_informal', 'foto_url', 'email', 'telefone', 'tipo_socio', 'num_licenca', 'direcao'])->whereNull('deleted_at')->where('ativo',1);
             $filtro = User::whereNull('deleted_at')->where('ativo', '1');

             if (isset($num_socio)) {
                 $filtro = $filtro->where('num_socio', $num_socio);
             }
             if (isset($nome_informal)) {
                 $filtro = $filtro->where('nome_informal', 'like', '%' . $nome_informal . '%');
             }
             if (isset($email)) {
                 $filtro = $filtro->where('email', 'like', '%' . $email . '%');
             }
             if (isset($tipo)) {
                 $filtro = $filtro->where('tipo_socio', $tipo);
             }
             if (isset($direcao)) {
                 $filtro = $filtro->where('direcao', $direcao);
             }



                 $users = $filtro->paginate(15)->appends([
                     'num_socio' => request('num_socio'),
                     'nome_informal' => request('nome_informal'),
                     'email' => request('email'),
                     'tipo' => request('tipo'),
                     'direcao' => request('direcao'),

                 ]);


         }
         else{
             $users=User::paginate(15);
         }

        $title="Lista de utilizadores";
        return view('users.list', compact('users','title'));

	}
	
	public function edit($id){

        $this->authorize('update_DirMe',User::findOrFail($id),App\User::class );
            $title = "Editar Utilizador ";
            $user= User::findOrFail($id);

        $classes= ClassesCertificados::all();
        $licencas =TiposLicencas::all();


return view('users.edit', compact('title', 'user','classes','licencas' ));



        //return view('users.edit', compact('title', 'user' ));

	}


	public function create(){
        $this->authorize('socio_Direcao', Auth::user());
		$title= "Adicionar Utilizadores";
        $classes= ClassesCertificados::all();
        $licencas =TiposLicencas::all();

        return view('users.create', compact('title', 'classes', 'licencas'));



	}

	public function destroy($id){

	    $this->authorize('delete_socio',User::findOrFail($id));
		$user= User::findOrFail($id);
        $movimentosAssociados= DB::table('movimentos')->select('id')->where('piloto_id',$id)->get();
        if($movimentosAssociados->isEmpty()){
            $user->forceDelete();
        }
        else {
            $user->delete(); // faz soft delete

        }
        return redirect()->action('UserController@index');
		
		//return redirect()->route('users.list')->with('success', 'User deleted successfully'); -- testar
	}


	public function store(UserStoreRequest $request){ // depois de login meter ou so Request

	    //$this->validate(request(),[]);// colocar campos para validar aqui


        $this->authorize('socio_Direcao', Auth::user());




if($request->tipo_socio!="P" ){
    $user = new User();
    $user->fill($request->only(['name','nome_informal', 'email', 'data_nascimento','nif', 'telefone', 'endereco', 'num_socio', 'quota_paga', 'sexo', 'tipo_socio','direcao', 'instrutor','aluno']));
    $user->password = $request->data_nascimento;//Hash::make($request->data_nascimento);
    $user->password_inicial=true;

    if(! is_null($request['file_foto'])){
    $image = $request->file('file_foto');
    $name = time().'.'.$image->getClientOriginalExtension();

  //  Storage::putFileAs('public/img', $image, $name);
    $path = $request->file('file_foto')->storeAs('public/fotos', $name);
    $user->foto_url = $name;
    }
    $user->save();
    $user->sendEmailVerificationNotification();

}


if($request->tipo_socio=="P" ){
    $user = new User();
    $user->fill($request->only(['name','nome_informal', 'email', 'data_nascimento','nif', 'telefone', 'endereco', 'num_socio', 'quota_paga', 'sexo', 'tipo_socio','direcao', 'instrutor','aluno', 'certificado_confirmado','licenca_confirmada','num_licenca','tipo_licenca','validade_licenca', 'num_certificado', 'classe_certificado', 'validade_certificado']));
    $user->password =$request->data_nascimento; //Hash::make($request->data_nascimento);
    $user->password_inicial=true;
    if(! is_null($request['file_foto'])){
        $image = $request->file('file_foto');
        $name = time().'.'.$image->getClientOriginalExtension();

        //  Storage::putFileAs('public/img', $image, $name);
        $path = $request->file('file_foto')->storeAs('public/fotos', $name);
        $user->foto_url = $name;
    }
    $user->save();
$user->sendEmailVerificationNotification();

}



      /*  $user->foto_url = "";
        $user->ativo=false;
        $user->password_inicial=true;
        $user->password = Hash::make($request->data_nascimento);
		$user->save();
		*/


      //$request->user()->sendEmailVerificationNotification();


		return redirect()
		->action('UserController@index')
		->with('success', 'User added successfully!');
	}

	public function update(UserUpdateRequest $request,$socio){

        $this->authorize('update_DirMe', User::findOrFail($socio),App\User::class);
		if ($request->has('cancel')) {
            return redirect()->action('UserController@index');
		}




		$user = User::findOrFail($socio);
        if(! is_null($request['file_foto'])) {
            $old_foto= 'public/fotos/'.$user->foto_url;


            $image = $request->file('file_foto');
            $newFotoUrl = time().'.'.$image->getClientOriginalExtension();

            $path = $request->file('file_foto')->storeAs('public/fotos', $newFotoUrl);
            // OR

            // Storage::putFileAs('public/img', $image, $name);
            $user->foto_url = $newFotoUrl;


            if(Storage::exists($old_foto)) {
                Storage::delete($old_foto);
            }

        }




        if(Auth::user()->can('socio_normal', Auth::user())) {
                $user->fill($request->except([ 'num_socio', "ativo", "quota_paga", "sexo", "tipo_socio", "direcao", "instrutor", "aluno", "certificado_confirmado", "licenca_confirmada"]));
                $user->num_licenca=null;
                $user->tipo_licenca=null;
                $user->validade_licenca=null;
                $user->num_certificado=null;
                $user->classe_certificado=null;
                $user->validade_certificado=null;
                $user->save();
//faltava isto no teste 8_B....
            }


        if(Auth::user()->can('socio_piloto', Auth::user())){
            $user->fill($request->except(['password','email_verified_at', 'remember_token', 'created_at', 'updated_at','deleted_at', 'num_socio', 'tipo_socio', 'sexo', 'quota_paga', 'ativo','password_inicial','direcao', 'foto_url', 'instrutor', 'aluno','certificado_confirmado']));

            // $user->fill($request->except('password'));
            if(User::findOrFail(Auth::id())->num_licenca != $request->num_licenca){
                $user->licenca_confirmada=false;
            }
            if(User::findOrFail(Auth::id())->num_certificado != $request->num_certificado){
                $user->certificado_confirmado=false;
            }
            $user->save();

        }


        if(Auth::user()->can('socio_Direcao', Auth::user())) {

        $user->fill($request->all());
        $user->save();



        }









     /*   //para utilizador normal
        if (Auth::user()->can('socio_piloto', Auth::user())){
            $user->fill($request->all());
            $user->save();

        }elseif(Auth::user()->can('socio_normal', Auth::user())){
            $user->fill($request->except(['id','num_socio',"ativo", "quota_paga","sexo","tipo_socio","direcao", "instrutor","aluno", "certificado_confirmado","licenca_confirmada"]));
            $user->save();
        }
        else{
            $user->fill($request->except('password'));
        }*/








        return redirect()->action('UserController@index');

	}

    public function showEditPassword(){
        return view('users.editPassword');
    }

    public function editPassword(UpdatePassword $request){

        $data = $request->all();
        $user= User::findOrFail(Auth::id());
        $user->password_inicial=0;
        $user->update($data);
        return redirect(route('home'))
            ->with('info', 'Your profile has been updated successfully.');


    }


    public function certificado_pdf($id){


        $user=User::findOrFail($id);
        //$pdf = PDF::loadView('users.licencaPdf', $user);

        $title="Certificado";
        $pdf = PDF::loadView('users.certificadoPdf',compact('user','title'));




        return $pdf->download('Certificado.pdf');


        //$content = $pdf->download('Certificado.pdf')->getOriginalContent();

        //Storage::put('public/teste.pdf',$content) ;

    }




    public function licenca($id){

        $user=User::findOrFail($id);
        //$pdf = PDF::loadView('users.licencaPdf', $user);



        $view = View('users.licenca', compact('user'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view->render());
        return $pdf->stream();

    }
       // return view('users.licenca',compact('user','title'));
public function ativarDesativar(Request $request, $id){
    $this->authorize('socio_Direcao', Auth::user());


        $user= User::findOrFail($id);

        if($user->ativo!=$request->ativo){
            $user->ativo=!$user->ativo;
        }


        $user->save();


    return redirect()->action('UserController@index');

}


public function resetQuotas(){
    $this->authorize('socio_Direcao', Auth::user());

    $users= User::all();
        foreach ($users as $user){
            if($user->quota_paga==1){
                $user->quota_paga=0;
            }
            $user->save();
        }



    return redirect()->action('UserController@index');

}

public function resetAtivosSemQuota(){
    $this->authorize('socio_Direcao', Auth::user());

    $users=User::all();
    foreach ($users as $user){
        if($user->quota_paga==0){
            $user->ativo=0;
        }
        $user->save();

    }
    return redirect()->action('UserController@index');

}

    public function quotaPaga(Request $request, $id){

        $this->authorize('socio_Direcao', Auth::user());
        $user= User::findOrFail($id);
        if($user->quota_paga!= $request->quota_paga){
            $user->quota_paga=!$user->quota_paga;
        }

        $user->save();


        return redirect()->action('UserController@index');

    }




    public function certificado($id){

        $user=User::findOrFail($id);
        //$pdf = PDF::loadView('users.licencaPdf', $user);



        $view = View('users.certificado', compact('user'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view->render());

        return $pdf->stream();


        // return view('users.licenca',compact('user','title'));

    }

    public function licenca_PDF($id){
        $user=User::findOrFail($id);


        //$pdf = PDF::loadView('users.licencaPdf', $user);


        $pdf = PDF::loadView('users.licencaPdf',compact('user'));


        //return $pdf->();

        //$content = $pdf->download()->getOriginalContent();

        //Storage::put('public/teste.pdf',$content) ;
    }

    public function sendReactivateEmail($id){
        $this->authorize('socio_direcao',User::findOrFail($id),Auth::user());
        $user=User::findOrFail($id);
        $user->resend();
    }



}
