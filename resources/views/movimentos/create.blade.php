@extends('layouts.app')
@section('content')


    @if (count($errors) > 0)
        @include('shared.errors')
    @endif



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
{{--
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
    --}}


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
function precoVoo(array) {
var selectedValue=document.getElementById("aeronave").value;
     var valores = {!! json_encode($valores) !!};//aeronaves array com os valores dos precos
console.log(valores);
if(selectedValue!=null){
array.forEach(function(element) {
    var value=element.matricula;
  if(selectedValue==value){
    var horasInicio=document.getElementById("conta_horas_inicio").value;
   var horasFinal=document.getElementById("conta_horas_fim").value;
    if(horasInicio!="" && horasFinal!=""){
var horas=Math.floor(horasFinal-horasInicio);
    console.log(horas);
  var hora=Math.floor((horasFinal-horasInicio)/10);
  var conta_horas_minutos=(horas%10);//obter ultimo valor
var preco=0;
if(conta_horas_minutos!=0){
  for (var i = 0 ; i <valores.length ; i++) {
      for (var j = 0 ; j <valores[0].length ; j++) {
      if(valores[i][j]['matricula']==selectedValue){
          console.log("entrou matricula" +valores[i][j]['matricula']);
        if(valores[i][j]['unidade_conta_horas']==conta_horas_minutos){
            //conta correta aqui por fazer 
          var minutos=valores[i][j]['minutos'];
          console.log("entrou");
          console.log(valores[i][j]['matricula']);
          preco=valores[i][j]['preco'];
          console.log(conta_horas_minutos);
          console.log(preco);//preco dos minutos
      }
      }
  }
  }
}
  console.log(hora);//hora 
    console.log("hora"+hora);
    console.log("minutos"+conta_horas_minutos);
  if(conta_horas_minutos==0){
  var tempo_voo=hora*60;
  console.log(tempo_voo);
}else{
  var tempo_voo=hora*60+minutos;
  console.log(tempo_voo);
}

  console.log(tempo_voo);
    document.getElementById("tempo_voo").value=tempo_voo;


    

    var preco_hora=parseInt(element.preco_hora*hora);
    var preco_minuto=parseInt(preco);
    console.log(preco_hora);
    console.log(preco_minuto)

    var preco_final=preco_hora+preco_minuto;

    console.log(preco_final);

    document.getElementById("preco_voo").value=(preco_final);
    
    }
 
  }
});
 
 
}
}</script>


    <form action="{{action('MovimentoController@store')}}" method="post">
        @csrf

       <h1>{{$title}}</h1>
  
     

        <div>Date:</div></label><input type="date" name="data"  @if (isset($movimento)) value="{{$movimento->data}}" @endif>

        <div>Hora Descolagem:</div><input id="hora_descolagem" type="time" name="hora_descolagem"  @if (isset($movimento)) value="{{$hora_inicio}}" @endif >

        <div>Hora Aterragem</div><input id="hora_aterragem" type="time" name="hora_aterragem" @if (isset($movimento)) value="{{$hora_fim}}" @endif>

        <label >Aeronave</label>
        <select name="aeronave"  id="aeronave" onchange="precoVoo({{$aeronaves}})">
            <option></option>
            @foreach ($aeronaves as $aeronave)
                <option value="{{ $aeronave->matricula }}"@if (isset($movimento)) 
                    {{ 
                    ( $aeronave->matricula == $movimento->aeronave) ? 'selected' : $movimento->aeronave 
                }}
                @endif>
                     {{ $aeronave->matricula }} </option>
            @endforeach    </select>
        <br>


        <div>
            <label for="inputNumDiario">Numero Diario</label>
            <input type="number" name="num_diario" id="inputNumDiario"  @if (isset($movimento)) value="{{$movimento->num_diario}}" @endif  placeholder="Numero Diario" >
        </div>

        <div>
            <label for="inputServico">Numero Servico</label>
            <input type="number" name="num_servico" id="inputNumServico"  placeholder="Numero Servico"   @if (isset($movimento)) value={{$movimento->num_servico}} @endif>
        </div>

        @if (isset($movimento))
            <label >Piloto ID</label>
            <select name="piloto_id" id="piloto_id" onchange="myLabelsSocio({{$socios}})">
                <option></option>
                @foreach ($socios as $socio)
                    <option value="{{$socio->id}}" {{(  $socio->id == $movimento->piloto_id) ? 'selected' : $movimento->piloto_id }}> {{ $socio->id }}
                    </option>

              

                @endforeach    </select>

        @else
        <label>ID Piloto:</label>
        <select id="piloto_id"name="piloto_id" onchange="myLabelsSocio({{$socios}})">
      
             @foreach ($socios as $socio)
             
                    <option value="{{$socio->id}}"> {{ $socio->id }}
 
         @endforeach
        
        
        </select>
        @endif

        <label id="socio_label" readonly="readonly"> </label>
        <div></div>




        <label> Natureza</label>
        @if (isset($movimento))
         <select   name="natureza" id="natureza" onchange="myFunction();">
                <option value="{{ $movimento->natureza}}">@if ($movimento->natureza=='I')
                        Instruçao
                    @endif
                    @if ($movimento->natureza=='T')
                        Treino
                    @endif
                    @if ($movimento->natureza=='E')
                        Especial
                    @endif
                </option>

                @if ($movimento->natureza!='I')
                    <option value="I">Instruçao</option>

                @endif

                @if ($movimento->natureza!='T')
                    <option value="T">Treino</option>
                @endif

                @if ($movimento->natureza!='E')
                    <option value="E">Especial</option>
                @endif

            </select>
        @else
        <select name="natureza" id="natureza" onchange="myFunction();">
            <option></option>
            <option value="I">Instrução</option>
            <option value="T">Treino</option>
            <option value="E">Especial</option>
        </select>
        @endif




        <div></div>

        <label> Aerodromo Chegada:</label>
            @if (isset($movimento))
             <select name="aerodromo_chegada">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}} > {{$aerodromo->nome}}</option>
          @endforeach       
        </select>  
            @else
        <select name="aerodromo_chegada">
            <option></option>
            @foreach ($aerodromos as $aerodromo)
                <option value="{{$aerodromo->code}}"> {{$aerodromo->nome}}</option>
            @endforeach
        </select>
        @endif


    
        <div></div>
        <label> Aerodromo Partida:</label>

            @if(isset($movimento))

           <select name="aerodromo_partida">
         <option></option>
                 @foreach ($aerodromos as $aerodromo)
                              <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}}> {{$aerodromo->nome}}</option>
          @endforeach    
        </select>    

        @else


        <select name="aerodromo_partida">
            <option></option>
            @foreach ($aerodromos as $aerodromo)
                <option value="{{$aerodromo->code}}"> {{$aerodromo->nome}}</option>
            @endforeach
        </select>

        @endif

        <div>
            <label for="num_aterragens">Numero Aterragens</label>
            <input  type="number" name="num_aterragens" id="num_aterragens"  @if (isset($movimento)) value="{{$movimento->num_aterragens}}" @endif placeholder="Numero de Aterragens"  >
        </div>




        <div>
            <label for="inputDescolagens">Numero de Descolagens</label>
            <input type="number" name="num_descolagens" id="num_descolagens"  placeholder="Numero de Descolagens"   @if (isset($movimento)) value={{$movimento->num_descolagens}} @endif>   
        </div>


        <div>
            <label for="inputDescolagens">Numero de Pessoas</label>
            <input type="number" name="num_pessoas" id="num_pessoas"  @if (isset($movimento)) value="{{$movimento->num_pessoas}}" @endif  placeholder="Numero de Pessoas" >
        </div>





        <div>
            <label for="inputDescolagens">Conta Horas Inicio</label>
            <input type="text" name="conta_horas_inicio" id="conta_horas_inicio"  placeholder="Conta Horas Inicio"  @if (isset($movimento)) value="{{$movimento->conta_horas_inicio}}" @endif onchange="precoVoo({{$aeronaves}})">
        </div>






        <div>
            <label for="inputDescolagens">Conta Horas Fim</label>
            <input type="number" name="conta_horas_fim" id="conta_horas_fim"  placeholder="Conta Horas Fim"  @if (isset($movimento)) value="{{$movimento->conta_horas_fim}}" @endif onchange="precoVoo({{$aeronaves}})">
        </div>





        <div>
            <label >Tempo de voo</label>
            <input  type="number" name="tempo_voo" id="tempo_voo"  @if (isset($movimento)) value="{{$movimento->tempo_voo}}" @endif placeholder="Tempo de Voo" readonly>
        </div>


{{--tempo voo e preco voo deveriam ser hidden inputs, calculados posteriormente na funcao calculos--}}



        <div>
            <label>Preço de voo</label>
            <input   type="number" name="preco_voo" id="preco_voo"   @if (isset($movimento)) value="{{$movimento->preco_voo}}" @endif placeholder="Preço do Voo"  readonly>
        </div>





        <label>Forma de Pagamento</label>
     @if(isset($movimento))
       <select   name="modo_pagamento" id="modo_pagamento">
                <option value="{{ $movimento->modo_pagamento}}">@if ($movimento->modo_pagamento=='N')
                        Numerario
                    @endif
                    @if ($movimento->modo_pagamento=='M')
                        Multibanco
                    @endif
                    @if ($movimento->modo_pagamento=='T')
                        Transferencia
                    @endif
                      @if ($movimento->modo_pagamento=='P')
                        Pacote de Horas
                    @endif
                </option>

                @if ($movimento->modo_pagamento!='N')
                    <option value="N">Numerario</option>
                @endif

                 @if ($movimento->modo_pagamento!='M')
                    <option value="N">Multibanco</option>
                @endif

                 @if ($movimento->modo_pagamento!='T')
                    <option value="N">Transferencia</option>
                @endif


                 @if ($movimento->modo_pagamento!='P')
                    <option value="P">Pacote de Horas</option>
                @endif

            </select>

     @else
        <select name="modo_pagamento">
            <option></option>
            <option value="N">Numerario</option>
            <option value="M">Multibanco</option>
            <option value="T">Transferencia</option>
            <option value="P">Pacote de Horas</option>
        </select>
        @endif



        <div>
            <label for="inputDescolagens">Numero de Recibo</label>
            <input  type="number"  name="num_recibo" id="inputNumDescolagens"  @if (isset($movimento)) value="{{$movimento->num_recibo}}" @endif  placeholder="Numero de Recibo" >
        </div>





        <div>
            <label for="exampleFormControlTextarea1">Observacoes</label>
            <textarea  name="observacoes" id="exampleFormControlTextarea1" rows="3"> @if (isset($movimento)) {{$movimento->observacoes}} @endif</textarea>
        </div>




      <label id="tipo_instrucao" @if (isset($movimento) && $movimento->natureza!="I") style="display: none;" @endif >Tipo Instruçao</label>
         @if(isset($movimento))
          <select id="tipo_instrucao_select" name="tipo_instrucao"   @if (isset($movimento) && $movimento->natureza!="I") style="display: none;" @endif>
            <option value="{{$movimento->tipo_instrucao}}">@if ($movimento->tipo_instrucao=='D') Duplo @endif
              @if($movimento->tipo_instrucao=='S')
              Simples
              @endif
            </option>
                 @if ($movimento->tipo_instrucao!='D')
                <option value="D"> 
                        Duplo
                  </option>  @endif
                  @if($movimento->tipo_instrucao!='S')
                    <option value="S">
                        Simples
                   </option> @endif

          </select>
         @else
  
        <select name="tipo_instrucao" id="tipo_instrucao_select"  @if (isset($movimento) && $movimento->natureza!="I") style="display: none;" @endif>
            <option value="S">Simples</option>
            <option value="D">Duplo</option>
        </select>
        @endif


        <label id="instrutor_label1"  @if (isset($movimento) && $movimento->natureza!="I") style="display: none;" @endif >Instrutor</label>
         @if(isset($movimento))
         <select name="instrutor_id" id="instrutor_id" onload="myFunction()" onchange="myLabelsInstrutor({{$socios}})"  @if (isset($movimento) && $movimento->natureza!="I") style="display: none;" @endif >
                    <option></option>
                    @foreach ($socios as $socio)
                   @if (Auth::user()->can('socio_Piloto', Auth::user()) && $movimento->instrutor_id==auth()->user()->id) 
                  @if (auth()->user()->id==$socio->id)
                      <option value="{{$socio->id}}" {{(  $socio->id == $movimento->instrutor_id) ? 'selected' : $movimento->instrutor_id }}> {{ $socio->id }}
                    </option>
                  @endif
                 @else
                  @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                   <option value="{{$socio->id}}" {{(  $socio->id == $movimento->instrutor_id) ? 'selected' : $movimento->instrutor_id }}> {{ $socio->id }}
                    </option>
                    @endif
                    @endif
                    @if ($socio->id==$movimento->instrutor_id)
                        {{$instrutorEsp=$socio->name}}
                        @endif
                    @endforeach    </select>
@else
        <select name="instrutor_id" id="instrutor_id" onchange="myLabelsInstrutor({{$socios}})">
            <option></option>

            @foreach ($socios as $socio)
                   @if (Auth::user()->can('socio_Piloto', Auth::user())) 
                  @if (auth()->user()->id==$socio->id)
                    <option value="{{$socio->id}}"> {{ $socio->id }}</option>
                @endif
                @else
                 @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                          <option value="{{$socio->id}}"> {{ $socio->id }} </option>

                @endif
            @endif
            @endforeach
        </select>
@endif

        <label id="instrutor_label" readonly="readonly "></label>


@if(isset($movimento))
       <div>
            <label for="exampleFormControlTextarea1">Razao Conflito</label>
            <textarea name="justificacao_conflito" id="exampleFormControlTextarea1" rows="3" cols="50"></textarea>
        </div>


   
              <label>Tipo Conflito</label>
       <select  name="tipo_conflito" id="tipo_conflito" >
                <option value="{{$tipo_conflito}}">@if ($tipo_conflito=='B')
                        Buraco
                    @endif
                    @if ($tipo_conflito=='S')
                        Sobreposicao
                    @endif                  
                </option>


            </select>



  <div>
        <button type="submit" name="comConflitos">Save</button>
    </div>

@else
        <div>
            <button type="submit" name="ok">Save</button>

        </div>
@endif


          <div>
            <button type="submit" name="cancel">Cancel</button>

        </div>


    </form>



@endsection