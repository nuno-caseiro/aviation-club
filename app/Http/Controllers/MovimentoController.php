<?php

namespace App\Http\Controllers;
use App\Aeronave;
use App\User;
use App\Movimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    //
    public function index()
    {
       // if(Auth::user()->can('list', Auth::user())) {
       //     $movimentos = Movimento::paginate(15);
       // }elseif(Auth::user()->can('normal_ativo', Auth::user())) {
            $movimentos = Movimento::paginate(15);
       // }

        $users=User::all();
        $title = "List of Movimentos";
        return view('movimentos.list', compact('movimentos', 'title', 'users'));
    }





    public function edit($id)
    {

        $title = "Editar movimentos ";
        $movimento= Movimento::find($id);
        $aeronaves=Aeronave::all();
        $socios=User::all();

        return view('movimentos.edit', compact('title', 'movimento','aeronaves','socios'));
    }






    public function update(Request $request, $id){

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
        //falta validacao
        $movimentoModel= Movimento::find($id);

        //dd($request->all());
        //protected $fillable = ['id', 'aeronave', 'data_inf??', ' data_sup??', 'natureza', 'confirmado???','piloto??','instrutor??','meus_movimentos??'];

        $movimentoModel->aeronave=$request->members;
        $movimentoModel->natureza= $request->natureza;
        $movimentoModel->confirmado=$request->confirmado;
        $movimentoModel->piloto_id=$request->piloto_id;
        $movimentoModel->instrutor_id=$request->instrutor_id;
         $movimentoModel->tipo_instrucao=$request->tipo_instrucao;
             //dd($movimentoModel);

         if ($movimentoModel->instrutor_id!=$request->ins) {
             # code...
         }


        $movimentoModel->save();
        return redirect()->action('MovimentoController@index');
        //podemos dar nomes às rotas
    }



    public function create(){
        $title= "Adicionar Movimento";
        $aeronaves=Aeronave::all();   
        $socios=User::all();

        return view('movimentos.create', compact('title','aeronaves','socios'));
    }



    public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }


        $movimento=$request->all()+['id'=>'1','num_licenca_piloto'=>'5202','validade_licenca_piloto'=>'2020-05-28','tipo_licenca_piloto' =>'PPL(A)','num_certificado_piloto'=>'PT.19357','confirmado'=>'1','validade_certificado_piloto'=>'2020-05-29','classe_certificado_piloto'=>'Class 1'
            ];

        //estou a morrer por dentro nao percebo o erro so quero por um id ao calhas pq o meu delete tb nao da update nos meus ids tenho de fazer isso
        /*     data,
 hora_descolagem, hora_aterragem, aeronave, num_diario,
 num_servico, piloto_id, natureza, aerodromo_partida,
 aerodromo_chegada, num_aterragens, num_descolagens,
 num_pessoas, conta_horas_inicio, conta_horas_fim, tempo_voo,
 preco_voo, modo_pagamento, num_recibo, observacoes,
 tipo_instrucao, instrutor_id*/
//dd($request);
        /*   deu erro tb
        $movimento->id=1;
        $movimentoModel->data=$request->data;
        $movimentoModel->hora_aterragem=$request->hora_aterragem;
        $movimentoModel->hora_descolagem=$request->hora_descolagem;
        $movimentoModel->aeronave=$request->aeronave;
        $movimentoModel->confirmado=$request->num_servico;
        $movimentoModel->confirmado=$request->piloto_id;
        $movimentoModel->natureza= $request->aerodromo_partida;
        $movimentoModel->natureza= $request->aerodromo_chegada;
        $movimentoModel->natureza= $request->num_aterragens;
        $movimentoModel->natureza= $request->num_descolagens;
        $movimentoModel->natureza= $request->num_pessoas;
           $movimentoModel->natureza= $request->conta_horas_inicio;
        $movimentoModel->natureza= $request->conta_horas_fim;
        $movimentoModel->natureza= $request->tempo_voo; 
        $movimentoModel->natureza= $request->preco_voo;
        $movimentoModel->natureza= $request->modo_pagamento;
        $movimentoModel->natureza= $request->num_recibo;
        $movimentoModel->natureza= $request->observacoes;
        $movimentoModel->natureza= $request->tipo_instrucao;
        $movimentoModel->natureza= $request->instrutor_id;
            */
        // dd($movimento)  ;

        Movimento::create($movimento);

        return redirect()->action('MovimentoController@index');
    }



    public function destroy($id){
        $movimento= Movimento::find($id);
        $movimento->delete();


        return redirect()->action('MovimentoController@index');

    }


}
