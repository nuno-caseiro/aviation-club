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
         <select name="aeronave">       
              
              @foreach ($aeronaves as $aeronave) 
                 <option value="{{ $aeronave->matricula }}"> {{ $aeronave->matricula }} </option>
              @endforeach    </select> 
         <br>


              <div>
            <label for="inputNumDiario">Numero Diario</label>
            <input type="text" name="num_diario" id="inputNumDiario"  placeholder="Numero Diario" >
        </div>

                 <div>
            <label for="inputServico">Numero Servico</label>
            <input type="text" name="num_servico" id="inputNumServico"  placeholder="Numero Servico" >
        </div>

          <label>ID Piloto:</label>
            <select name="piloto_id">
              <option></option>
                @foreach ($socios as $socio)
                    @if($socio->tipo_socio=='P')
                      <option value="{{$socio->id}}"> {{ $socio->id }}
                @endif
           </option>
          @endforeach    
        </select>
        


     <div></div>

       
            <label> Natureza</label>    
                <select name="natureza">
                <option></option>                 
                <option value="I">Instrução</option>   
                <option value="T">Treino</option>
                <option value="E">Especial</option>
              </select>

       



<div></div>

                <label> Aerodromo Chegada:</label>    
               <select name="aerodromo_chegada">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"> {{$aerodromo->code}}</option>
          @endforeach       
        </select>       



<div></div>
  <label> Aerodromo Partida:</label>    
               <select name="aerodromo_partida">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"> {{$aerodromo->code}}</option>
          @endforeach    
        </select>    



         <div>
            <label for="num_aterragens">Numero Aterragens</label>
            <input type="text" name="num_aterragens" id="num_aterragens"  placeholder="Numero de Aterragens" >
        </div>




         <div>
            <label for="inputDescolagens">Numero de Descolagens</label>
            <input type="text" name="num_descolagens" id="inputNumDescolagens"  placeholder="Numero de Descolagens" >
        </div>


               <div>
            <label for="inputDescolagens">Numero de Pessoas</label>
            <input type="text" name="num_pessoas" id="num_pessoas"  placeholder="Numero de Pessoas" >
        </div>





         <div>
            <label for="inputDescolagens">Conta Horas Inicio</label>
            <input type="text" name="conta_horas_inicio" id="inputNumDescolagens"  placeholder="Conta Horas Inicio" >
        </div>






         <div>
            <label for="inputDescolagens">Conta Horas Fim</label>
            <input type="text" name="conta_horas_fim" id="inputNumDescolagens"  placeholder="Conta Horas Fim" >
        </div>





         <div>
            <label for="inputDescolagens">Tempo de voo</label>
            <input type="text" name="tempo_voo" id="inputNumDescolagens"  placeholder="Tempo de Voo" >
        </div>



         


         <div>
            <label for="inputDescolagens">Preço de voo</label>
            <input type="text" name="preco_voo" id="inputNumDescolagens"  placeholder="Preço do Voo" >
        </div>




       
          <label>Forma de Pagamento</label>    
                
                <select name="modo_pagamento">                 
                <option></option>
                <option value="N">Numerario</option>   
                <option value="M">Multibanco</option>
                <option value="T">Transferencia</option>
                <option value="P">Pacote de Horas</option>
              </select>




         <div>
            <label for="inputDescolagens">Numero de Recibo</label>
            <input type="text" name="num_recibo" id="inputNumDescolagens"  placeholder="Numero de Recibo" >
        </div>




       
 <div class="form-group">
    <label for="exampleFormControlTextarea1">Observacoes</label>
    <textarea  name=observacoes class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>

       
         <label>Tipo Instruçao</label>    
                <select name="tipo_instrucao">                 
                <option value="S">Simples</option>   
                <option value="D">Duplo</option>
              </select>



         <label>Instrutor</label>
                <select name="instrutor_id">
                  <option></option>
                    @foreach ($socios as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$socio->id}}"> {{ $socio->id }}</option>
                        @endif
                    @endforeach
          </select>





          <div>
              <button type="submit" name="ok">Save</button>

          </div>



    </form>

@endsection