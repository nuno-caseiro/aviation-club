<?php

namespace App\Http\Controllers;
use App\Movimento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovimentoController extends Controller
{
    //
    public function index()
{
$movimentos = Movimento::paginate(15);
$title = "List of Movimentos";
return view('movimentos.list', compact('movimentos', 'title'));
}





    public function edit($id)
    {

      
        

        $title = "Editar movimentos ";
       $movimento= Movimento::find($id);
        // $aeronave = Aeronave::where('matricula', '=', $matricula)->first();

        return view('movimentos.edit', compact('title', 'movimento'));
    }






    public function update(Request $request, $id){

        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
        //falta validacao
        $movimentoModel= Movimento::find($id);

        //dd($request->all());
//protected $fillable = ['id', 'aeronave', 'data_inf??', ' data_sup??', 'natureza', 'confirmado???','piloto??','instrutor??','meus_movimentos??'];
        $movimentoModel->id=$request->id;
         $movimentoModel->aeronave=$request->members;
          $movimentoModel->natureza= $request->natureza;
        $movimentoModel->confirmado=$request->confirmado;
        $movimentoModel->piloto_id=$request->piloto;
        $movimentoModel->instrutor_id=$request->instrutor;

        $movimentoModel->save();
        return redirect()->action('MovimentoController@index');
        //podemos dar nomes às rotas
    }
  


       public function create(){
        $title= "Adicionar Movimento";
        return view('movimentos.create', compact('title'));
    }



        public function store(Request $request)
    {
        if ($request->has('cancel')) {
            return redirect()->action('MovimentoController@index');
        }
      
     
        $movimento=['id'=>1]+$request->all(); //estou a morrer por dentro nao percebo o erro so quero por um id ao calhas pq o meu delete tb nao da update nos meus ids tenho de fazer isso
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
       //   dd($movimento)  ;
        Movimento::create($movimento);
        return redirect()->action('MovimentoController@index');
    }



   public function destroy($id){
        $movimento= Movimento::find($id);
        $movimento->delete();
       

        return redirect()->action('MovimentoController@index');

    }


}
