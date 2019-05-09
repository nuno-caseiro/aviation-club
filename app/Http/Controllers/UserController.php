<?php

namespace App\Http\Controllers;

use App\ClassesCertificados;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Hash;

class UserController extends Controller
{
/*
    public function __construct()
    {
        $this->middleware('auth');
    }
*/
    public function index()
	{
       // $this->authorize('list', User::class);
		$users = User::paginate(15);
		$title = "Lista de utilizadores";
		return view('users.list', compact('users', 'title'));
	}
	
	public function edit($id){
		$title = "Editar Utilizador ";
        $user= User::find($id);


        return view('users.edit', compact('title', 'user' ));

	}

/*    public function edit(User $id) testar este
    {
        $this->authorize('update', $id);
        return view('users.edit', compact('user'));
    }
*/
/*
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $user->fill($request->validated());
        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();
        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully!');
    }

*/

	public function create(){
        //$this->authorize('create', User::class);
		$title= "Adicionar Utilizadores";
        $classes= ClassesCertificados::all();
        return view('users.create', compact('title', 'classes'));

	}
/*
	public function create(){
		$this->authorize('create', User::class);

        $user = new User;
        return view('users.add', compact('user'));
	}
*/

	public function destroy($id){
		$user= User::find($id);
        $user->delete();
		return redirect()->action('UserController@index');
		
		//return redirect()->route('users.list')->with('success', 'User deleted successfully'); -- testar
	}
/*
	public function store(Request $request){
		if ($request->has('cancel')) {
            return redirect()->action('UserController@index');
		}
		
		$user=$request->all();

       User::create($user);
        return redirect()->action('UserController@index');


	}
	*/

	public function store(UserStoreRequest $request){ // depois de login meter ou so Request

	    //$this->validate(request(),[]);// colocar campos para validar aqui

        //$this->authorize('create', User::class); p as permissoes
		$user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
		$user->save();
		

		return redirect()
		->action('UserController@index')
		->with('success', 'User added successfully!');
	}

	public function update(Request $request,$socio){
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

		$user = User::find($socio);
        $user->fill($request->except('password'));
        $user->save();


        return redirect()->action('UserController@index');

	}

	public function getfile($id) {
		$user=User::find($id);
        
        return $path= $user->foto_url;
    }





    
	
}
