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

<script type="text/javascript">
function countHoras() {
var horaDescolagem=document.getElementById("hora_descolagem").value;
var horaAterragem=document.getElementById("hora_aterragem").value;
console.log("sadas"+horaAterragem.value);

console.log("sadas"+horaDescolagem.value);
  if(horaDescolagem!=null && horaAterragem!=null){
   //value start
  var start = Date.parse(horaDescolagem); //get timestamp
console.log(start);

  //value end
  var end = Date.parse(horaAterragem); //get timestamp
  console.log(end);
  totalHours = NaN;
  if (start < end) {
    totalHours = ((end - start)/1000/60/60); //horas
  }
    console.log("total de horas="+totalHours);
    document.getElementById("tempo_voo").setAttribute('value',totalHours);
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
    if(selectedValue==""){
        document.getElementById("socio_label").innerHTML="";
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
  if(selectedValue==""){
       document.getElementById("instrutor_label").innerHTML="";
  }
});
}
</script>



<script>
function precoVoo(array,movimentos) {
var selectedValue=document.getElementById("aeronave").value;
if(selectedValue!=null){
array.forEach(function(element) {
    var value=element.matricula;
  if(selectedValue==value){
    var horasInicio=document.getElementById("conta_horas_inicio").value;
   var horasFinal=document.getElementById("conta_horas_fim").value;
    if(horasInicio!="" && horasFinal!=""){
      
      //mt mais facil seria fazer um menos o outro e dividia
    /*  var minutosHoraFinal = horasFinal[horasFinal.length-1]*6;        
      var horaFinal=Math.round(horasFinal/10);
      



      var minutosHoraInicio= horasInicio[horasInicio.length-1]*6;
      var horaInicial=Math.round(horasInicio/10);

      var horas=horaFinal-horaInicial;

      var minutos=0;
      if(minutosHoraInicio<minutosHoraFinal){
        minutos=minutosHoraFinal-minutosHoraInicio;
      }else{
        if(minutosHoraFinal==minutosHoraInicio){
          minutos=minutosHoraInicio;
        }else{
          if(minutosHoraInicio>minutosHoraFinal){
            minutos=60-minutosHoraInicio+minutosHoraFinal;
          }
        }
      }


      console.log(minutosHoraFinal);
        console.log(horaFinal);
*/
  var horas=Math.floor(horasFinal-horasInicio);
    console.log(horas);
  var hora=Math.floor((horasFinal-horasInicio)/10);
  var minutos=horas%10;

  console.log(hora);//hora 
  console.log(minutos);//minuto
  var tempo_voo=horas;

    document.getElementById("tempo_voo").value=tempo_voo;
    document.getElementById("preco_voo").value=element.preco_hora*hora+(element.preco_hora*minutos/10);



    }
    
 
   
  }
  
});

 


 

}


}</script>








 <div>Date:</div></label><input type="date" name="data" >
 
 <div>Hora Descolagem:</div><input id="hora_descolagem" type="datetime-local" name="hora_descolagem">

   <div>Hora Aterragem</div><input id="hora_aterragem" type="datetime-local" name="hora_aterragem">
 
         <label >Aeronave</label>
         <select name="aeronave" " id="aeronave" onchange="precoVoo({{$aeronaves}},{{$movimentos}})">       
          <option></option>
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
            <input  type="number" name="num_aterragens" id="num_aterragens"  placeholder="Numero de Aterragens"  >
        </div>




         <div>
            <label for="inputDescolagens">Numero de Descolagens</label>
            <input type="number" name="num_descolagens" id="num_descolagens"  placeholder="Numero de Descolagens"  >
        </div>


               <div>
            <label for="inputDescolagens">Numero de Pessoas</label>
            <input type="number" name="num_pessoas" id="num_pessoas"  placeholder="Numero de Pessoas" >
        </div>





         <div>
            <label for="inputDescolagens">Conta Horas Inicio</label>
            <input type="text" name="conta_horas_inicio" id="conta_horas_inicio"  placeholder="Conta Horas Inicio"  onchange="precoVoo({{$aeronaves}},{{$movimentos}})">
        </div>






         <div>
            <label for="inputDescolagens">Conta Horas Fim</label>
            <input type="number"" name="conta_horas_fim" id="conta_horas_fim"  placeholder="Conta Horas Fim"  onchange="precoVoo({{$aeronaves}},{{$movimentos}})">
        </div>





         <div>
            <label >Tempo de voo</label>
            <input  type="number" name="tempo_voo" id="tempo_voo"  placeholder="Tempo de Voo" readonly>
        </div>



         


         <div>
            <label>Preço de voo</label>
            <input   type="number"" name="preco_voo" id="preco_voo"  placeholder="Preço do Voo"  readonly>
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
            <input  type="number"  name="num_recibo" id="inputNumDescolagens"  placeholder="Numero de Recibo" >
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