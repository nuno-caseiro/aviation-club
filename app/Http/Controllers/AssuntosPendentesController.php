<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Movimento;

class AssuntosPendentesController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->authorize('socio_Direcao', Auth::user());

        $movimentosComConflitos = Movimento::where('tipo_conflito','S')->orwhere('tipo_conflito','B')->get();
        $movimentosPorConfirmar = Movimento::where('confirmado', '0')->get();
        $usersComLicencasPorValidar = User::where('licenca_confirmada', '0')->get();
        $usersComCertificadosPorValidar = User::where('certificado_confirmado', '0')->get();
        $movimentos=Movimento::all();
        $users=User::all();
        return view('pendentes', compact('movimentos','movimentosComConflitos', 'movimentosPorConfirmar', 
        'usersComLicencasPorValidar', 'usersComCertificadosPorValidar','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
