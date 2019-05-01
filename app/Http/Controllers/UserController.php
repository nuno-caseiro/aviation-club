<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
	{
		$users = User::All();
		$title = "Lista de utilizadores";
		return view('users.list', compact('users', 'title'));
	}
	
	public function edit($name){
		$title = "Editar Utilizador ";
        $user = User::where('name', '=', $name)->first();
        return view('users.edit', compact('title', 'user'));
	}
    

}
