<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Hash;

class UserController extends Controller
{
    public function index()
	{
		$users = User::paginate(15);
		$title = "Lista de utilizadores";
		return view('users.list', compact('users', 'title'));
	}
	
	public function edit($id){
		$title = "Editar Utilizador ";
        $user= User::find($id);
        return view('users.edit', compact('title', 'user'));

	}

	public function create(){
		$title= "Adicionar Utilizadores";

        return view('users.create', compact('title'));

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

	public function store(Request $request){

	    //$this->validate(request(),[]);// colocar campos para validar aqui
		$user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
		$user->save();
		

		return redirect()
		->route('users.list')
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
