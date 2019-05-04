@extends('master')
@section('content')

    <form action="{{action('MovimentoController@store')}}" method="post">
        @csrf
        data,
hora_descolagem, hora_aterragem, aeronave, num_diario,
num_servico, piloto_id, natureza, aerodromo_partida,
aerodromo_chegada, num_aterragens, num_descolagens,
num_pessoas, conta_horas_inicio, conta_horas_fim, tempo_voo,
preco_voo, modo_pagamento, num_recibo, observacoes,
tipo_instrucao, instrutor_id
         

 <div>Date:</div></label><input type="date" name="data" >

 <div>Hora Descolagem:</div><input min="date" type="datetime-local" name="hora_descolagem">

   <div>Hora Aterragem</div><input type="datetime-local" name="hora_aterragem">


    
         <label >Aeronave</label>
         <select name="members">       
              
              @foreach ($aeronaves as $aeronave) 
                 <option value="{{ $aeronave->matricula }}"> {{ $aeronave->matricula }} </option>
              @endforeach    </select> 
         <br>
         
       
            <label>Natureza</label>    
                <select name="natureza">                 
                <option value="I">I</option>   
                <option value="T">T</option>
                <option value="E">E</option>
              </select>

       





        <div>
            <label for="inputNumDiario">Numero Diario</label>
            <input type="text" name="numDiario" id="inputNumDiario"  placeholder="Numero Diario" >
        </div>


          <div>
            <label for="inputServico">Numero Servico</label>
            <input type="text" name="numSerivco" id="inputNumServico"  placeholder="Numero Servico" >
        </div>




          <div>
            <label for="inputPartida">Aerodromo de Partida</label>
            <input type="text" name="partida" id="inputPartida"  placeholder="Aerodromo de Partida" >
        </div>


          <div>
            <label for="inputChegada">Aerodromo de Chegada</label>
            <input type="text" name="chegada" id="inputChegada"  placeholder="Aerodromo de Chegada" >
        </div>





         <div>
            <label for="inputNumAterragens">Numero Aterragens</label>
            <input type="text" name="aterragens" id="inputNumAterragens"  placeholder="Numero de Aterragens" >
        </div>




         <div>
            <label for="inputDescolagens">Numero de Descolagens</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Numero de Descolagens" >
        </div>






         <div>
            <label for="inputDescolagens">Conta Horas Inicio</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Conta Horas Inicio" >
        </div>






         <div>
            <label for="inputDescolagens">Conta Horas Fim</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Conta Horas Fim" >
        </div>





         <div>
            <label for="inputDescolagens">Tempo de voo</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Tempo de Voo" >
        </div>



         


         <div>
            <label for="inputDescolagens">Preço de voo</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Preço do Voo" >
        </div>



       
          <label>Forma de Pagamento</label>    
                <select name="pagamento">                 
                <option value="N">N</option>   
                <option value="M">M</option>
                <option value="T">T</option>
                <option value="P">P</option>
              </select>




         <div>
            <label for="inputDescolagens">Numero de Recibo</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="Numero de Recibo" >
        </div>




       
 <div class="form-group">
    <label for="exampleFormControlTextarea1">Observacoes</label>
    <textarea  name=observacoes class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

       
         <label>Tipo Instruçao</label>    
                <select name="tipo_instrucao">                 
                <option value="S">I</option>   
                <option value="D">T</option>
              </select>



         <div>
            <label for="inputDescolagens">ID  do instrutor</label>
            <input type="text" name="descolagens" id="inputNumDescolagens"  placeholder="ID do instrutor" >
        </div>





          <div>
              <button type="submit" name="ok">Save</button>

          </div>




    </form>

@endsection