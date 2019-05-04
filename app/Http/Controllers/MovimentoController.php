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
      
        $movimento=$request->data();
        $movimento=$request->all();
        Movimento::create($movimento);
        return redirect()->action('MovimentoController@index');
    }



   public function destroy($id){
        $movimento= Movimento::find($id);
        $movimento->delete();
       

        return redirect()->action('MovimentoController@index');

    }


}
