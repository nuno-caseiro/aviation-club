<?php

namespace App\Http\Controllers;

use App\AeronavesModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AeronavesController extends Controller
{
    public function index(){
        $aeronaves= AeronavesModel::All();
        $title= "Lista de Aeronaves";
        return view('aeronaves.list', compact('aeronaves', 'title'));

    }
}
