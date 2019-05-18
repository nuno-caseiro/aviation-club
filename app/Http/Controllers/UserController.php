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

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        //$users= new \stdClass();
        //$this->authorize('list', User::class);


         if(Auth::user()->can('socio_Direcao', User::class)){
            $users = User::paginate(15);
        }elseif(Auth::user()->can('socio_normal', User::class)) {
        //$users = User::where('ativo', '=', '1')->paginate(15);

        $num_socio=request()->query('num_socio');
        $nome_informal=request()->query('nome_informal');
        $email=request()->query('email');
        $tipo_socio=request()->query('tipo_socio');
        $direcao=request()->query('direcao');
        $filtro = User::where('ativo','=','1');

        if (isset($num_socio)) {
            $filtro = $filtro->where('num_socio', $num_socio);
        }
        if ($nome_informal) {
            $filtro = $filtro->where('nome_informal', 'like','%'.$nome_informal.'%');
        }
        if ($email) {
            $filtro = $filtro->where('email', $email);
        }
        if ($tipo_socio) {
            $filtro = $filtro->where('tipo_socio', $tipo_socio);
        }
        if ($direcao) {
            $filtro = $filtro->where('direcao', $direcao);
        }

            $users=$filtro->paginate(15);
        }


        $title="Lista de utilizadores";
        return view('users.list', compact('users','title'));

	}
	
	public function edit($id){

        $this->authorize('update_DirMe', User::findOrFail($id), User::class);
            $title = "Editar Utilizador ";
            $user= User::findOrFail($id);





            return view('users.edit', compact('title', 'user' ));

	}


	public function create(){
        $this->authorize('socio_Direcao', User::class);
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


	public function store(UserStoreRequest $request, User $user){ // depois de login meter ou so Request

	    //$this->validate(request(),[]);// colocar campos para validar aqui

        $this->authorize('socio_Direcao', User::class);



        $image = $request->file('file_foto');
        $name = time().'.'.$image->getClientOriginalExtension();

        $path = $request->file('file_foto')->storeAs('public/img', $name);

		$user = new User();
        $user->fill($request->all());
        $user->foto_url = $name;
        $user->ativo=false;
        $user->password_inicial=true;
        $user->password = Hash::make($request->data_nascimento);
		$user->save();
		

		return redirect()
		->action('UserController@index')
		->with('success', 'User added successfully!');
	}

	public function update(UserUpdateRequest $request,$socio){

        $this->authorize('update_DirMe', Auth::user(),User::class);
		if ($request->has('cancel')) {
            return redirect()->action('UserController@index');
		}



        /*$this->validate($request, [
            'num_socio'=>'required|',
            'name' => 'required|alpha_dash',
            'email' => 'required|email',
            'type' => 'required|between:0,2'
        ]);

        */





		$user = User::findOrFail($socio);
        if(! is_null($request['file_foto'])) {
            $image = $request->file('file_foto');
            $name = time().'.'.$image->getClientOriginalExtension();

            $path = $request->file('file_foto')->storeAs('public/img', $name);
            // OR

            // Storage::putFileAs('public/img', $image, $name);
            $user->foto_url = $name;

        }


            $user->fill($request->except('password'));





        $user->save();


        return redirect()->action('UserController@index');

	}

    public function showEditPassword(){
        return view('users.editPassword');
    }

    public function editPassword(UpdatePassword $request){

        $data = $request->all();
        $user= User::findOrFail(Auth::id());
        $user->update($data);
        return redirect(route('home'))
            ->with('info', 'Your profile has been updated successfully.');


    }





    
	
}
