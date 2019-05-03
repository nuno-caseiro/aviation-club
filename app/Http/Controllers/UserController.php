<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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

	/*public function destroy($id){
		$utilizador= User::find($id);
        $utilizador->delete();
        return redirect()->action('UserController@index');
	}
    */
	
}
