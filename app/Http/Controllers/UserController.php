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
		$users = User::All();
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

	/*public function destroy($id){
		$utilizador= User::find($id);
        $utilizador->delete();
        return redirect()->action('UserController@index');
	}
    */
	
}
