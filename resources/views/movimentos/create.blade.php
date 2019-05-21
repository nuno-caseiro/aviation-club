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
         
<script>
function myFunction() {
var selectedValue=document.getElementById("natureza").value;
if(selectedValue != "I") {
    document.getElementById("instrutor_id").style="display: none;"
    document.getElementById("instrutor_label").style="display: none;"
     document.getElementById("instrutor_label1").style="display: none;"
    document.getElementById("tipo_instrucao").style="display: none;"
    document.getElementById("tipo_instrucao_select").style="display: none;"
     document.getElementById("instrutor_id").value=null;
    document.getElementById("instrutor_label").value=null;
     document.getElementById("instrutor_label1").value=null;
    document.getElementById("tipo_instrucao").value=null;
    document.getElementById("tipo_instrucao_select").value=null;

}else{
   document.getElementById("instrutor_id").style="display: ?;"
    document.getElementById("instrutor_label").style="display: ?;"
    document.getElementById("tipo_instrucao").style="display: ?;"
    document.getElementById("tipo_instrucao_select").style="display: ?;"
    document.getElementById("instrutor_label1").style="display: ?;"
}
}
</script>

<script>
function myLabelsSocio(array) {
var selectedValue=document.getElementById("piloto_id").value;
array.forEach(function(element) {
    var value=element.id;
  if(selectedValue==value){
    document.getElementById("socio_label").innerHTML=element.name;
  }
});

}
</script>

<script>
function myLabelsInstrutor(array) {
var selectedValue=document.getElementById("instrutor_id").value;
array.forEach(function(element) {
    var value=element.id;
  if(selectedValue==value){
    document.getElementById("instrutor_label").innerHTML=element.name;
  }
});
}
</script>


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
            <input type="number" name="num_diario" id="inputNumDiario"  placeholder="Numero Diario" >
        </div>

                 <div>
            <label for="inputServico">Numero Servico</label>
            <input type="number" name="num_servico" id="inputNumServico"  placeholder="Numero Servico" >
        </div>

          <label>ID Piloto:</label>
            <select id="piloto_id"name="piloto_id" onchange="myLabelsSocio({{$socios}})">
              <option></option>
                @foreach ($socios as $socio)
                    @if($socio->tipo_socio=='P')
                      <option value="{{$socio->id}}"> {{ $socio->id }}
                @endif
           </option>
          @endforeach    
        </select>
        <label id="socio_label" readonly="readonly"> </label>


     <div></div>

       
            <label> Natureza</label>    
                <select name="natureza" id="natureza" onchange="myFunction();">
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
                      <option value="{{$aerodromo->code}}"> {{$aerodromo->nome}}</option>
          @endforeach       
        </select>       



<div></div>
  <label> Aerodromo Partida:</label>    
               <select name="aerodromo_partida">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"> {{$aerodromo->nome}}</option>
          @endforeach    
        </select>    



         <div>
            <label for="num_aterragens">Numero Aterragens</label>
            <input type="number" name="num_aterragens" id="num_aterragens"  placeholder="Numero de Aterragens" >
        </div>




         <div>
            <label for="inputDescolagens">Numero de Descolagens</label>
            <input type="number" name="num_descolagens" id="inputNumDescolagens"  placeholder="Numero de Descolagens" >
        </div>


               <div>
            <label for="inputDescolagens">Numero de Pessoas</label>
            <input type="number" name="num_pessoas" id="num_pessoas"  placeholder="Numero de Pessoas" >
        </div>





         <div>
            <label for="inputDescolagens">Conta Horas Inicio</label>
            <input type="number" name="conta_horas_inicio" id="inputNumDescolagens"  placeholder="Conta Horas Inicio" >
        </div>






         <div>
            <label for="inputDescolagens">Conta Horas Fim</label>
            <input type="number"" name="conta_horas_fim" id="inputNumDescolagens"  placeholder="Conta Horas Fim" >
        </div>





         <div>
            <label for="inputDescolagens">Tempo de voo</label>
            <input type="number" name="tempo_voo" id="inputNumDescolagens"  placeholder="Tempo de Voo" >
        </div>



         


         <div>
            <label for="inputDescolagens">Preço de voo</label>
            <input type="number"" name="preco_voo" id="inputNumDescolagens"  placeholder="Preço do Voo" >
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

       
         <label id="tipo_instrucao">Tipo Instruçao</label>    
                <select name="tipo_instrucao" id="tipo_instrucao_select">                 
                <option value="S">Simples</option>   
                <option value="D">Duplo</option>
              </select>



         <label id="instrutor_label1">Instrutor</label>
                <select name="instrutor_id" id="instrutor_id" onchange="myLabelsInstrutor({{$socios}})">
                  <option></option>
                    @foreach ($socios as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$socio->id}}"> {{ $socio->id }}</option>
                        @endif
                    @endforeach
          </select>


               <label id="instrutor_label" readonly="readonly "></label>


          <div>
              <button type="submit" name="ok">Save</button>

          </div>



    </form>




@endsection