@extends('layouts.app')
@section('content')


    @if (count($errors) > 0)
        @include('shared.errors')
    @endif




    @can(Auth::user()->can('isDirecao', Auth::user()) || (auth()->user()->id==$movimento->piloto_id) || (auth()->user()->id==$movimento->instrutor_id)) 
  @endcan




@if($movimento->confirmado=="1")
    <h1>Movimento nao pode ser alterado porque ja foi confirmado</h1>
@else
<script>
function myFunction() {
var selectedValue=document.getElementById("natureza").value;
if(selectedValue != "I") {
    document.getElementById("instrutor_id").style="display: none;"
    document.getElementById("instrutor_label").style="display: none;"
    if(document.getElementById("instrutorEsp")!=null){
    document.getElementById("instrutorEsp").style="display: none;"
        }
    document.getElementById("tipo_instrucao").style="display: none;"
     if(document.getElementById("tipo_instrucao_select")!=null){
    document.getElementById("tipo_instrucao_select").style="display: none;"
}
   
}else{
   document.getElementById("instrutor_id").style="display: ?;"
    document.getElementById("instrutor_label").style="display: ?;"
     if(document.getElementById("instrutorEsp")!=null){
    document.getElementById("instrutorEsp").style="display: ?;"
    }
    document.getElementById("tipo_instrucao").style="display: ?;"
       if(document.getElementById("tipo_instrucao_select")!=null){
    document.getElementById("tipo_instrucao_select").style="display: ?;"
    }
}
}

</script>






<script type="text/javascript">
window.addEventListener("load",function(){
    document.getElementById("natureza");
},false);
</script>





<script>
function myLabelsSocio(array) {
var selectedValue=document.getElementById("socio").value;
array.forEach(function(element) {
    var value=element.id;
  if(selectedValue==value){
    document.getElementById("socioName").innerHTML=element.name;
  }
   if(selectedValue==""){
    document.getElementById("socioName").innerHTML="";
  }
});

}
</script>

<script>
function myLabelsInstrutor(array) {

var selectedValue=document.getElementById("instrutor_id").value;
console.log(selectedValue);
array.forEach(function(element) {
    var value=element.id;
  if(selectedValue==value )
  {
    document.getElementById("instrutorEsp").innerHTML=element.name;
  }
    if(selectedValue==""){
    document.getElementById("instrutorEsp").innerHTML="";
  }
});

}
</script>

    <form method="POST" action="{{action('MovimentoController@update', $movimento->id)}}"  >
        @csrf

        <input type="hidden" name="method" value="PUT">

        <input type="text" name="confirmar" value="0">

{{$instrutorEsp=null}}
{{$socioEsp=null}}
        <div class="card-header">Editar Movimento</div>



        @if (isset($conflitos))
        <label>$title</label>
        <input type="text" name="tipo_conflito" value="{{$movimento->tipo_conflito}}"> 
         <div>
            <label for="exampleFormControlTextarea1">Razao Conflito</label>
            <textarea name="justificacao_conflito" id="exampleFormControlTextarea1" rows="3" cols="50">{{$movimento->justificacao_conflito}}</textarea>
        </div>
        @endif












            <label >Aeronave</label>
            <select name="aeronave">
                @foreach ($aeronaves as $aeronave)
                    <option value="{{ $aeronave->matricula }}" {{ ( $aeronave->matricula == $movimento->aeronave) ? 'selected' : $movimento->aeronave }}> {{ $aeronave->matricula }} </option>
                @endforeach    </select>



                <div>Date:<input name="data" value="{{$movimento->data}}" type="date" ></div>

         <div>Hora Descolagem:</div><input name="hora_descolagem" value="{{date('H:i', strtotime($movimento->hora_descolagem)) }}" type="time">

   <div>Hora Aterragem</div><input type="time" name="hora_aterragem" value="{{date('H:i', strtotime($movimento->hora_aterragem)) }}">


            <br>
            <label>Natureza</label>
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



      
          <label id='tipo_instrucao'>Tipo Instruçao</label>
          <select id="tipo_instrucao_select" name="tipo_instrucao" required>
            <option value="{{$movimento->tipo_instrucao}}">@if ($movimento->tipo_instrucao=='D') Duplo @endif
              @if($movimento->tipo_instrucao=='S')
              Simples
              @endif
              @if (is_null($movimento->tipo_instrucao))

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
      

          



            <label >Socios</label>
            <select name="piloto_id" id="socio" onchange="myLabelsSocio({{$socios}})">
                <option></option>
                @foreach ($socios as $socio)
                    <option value="{{$socio->id}}" {{(  $socio->id == $movimento->piloto_id) ? 'selected' : $movimento->piloto_id }}> {{ $socio->id }}
                    </option>

                    @if ($socio->id==$movimento->piloto_id)
                  {{$socioEsp=$socio->name}}
                    @endif


                @endforeach    </select>

            
            <label id="socioName">{{$socioEsp}}</label>


             <div>
                <label id="instrutor_label" >Instrutor</label>
                <select name="instrutor_id" id="instrutor_id" onload="myFunction()" onchange="myLabelsInstrutor({{$socios}})" >
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
                    @endforeach
                </select>
        </div>

            
            <label  id="instrutorEsp">{{$instrutorEsp}}</label>
    

               <label> Aerodromo Chegada:</label>    
               <select name="aerodromo_chegada">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}} > {{$aerodromo->nome}}</option>
          @endforeach       
        </select>       



<div>
  <label> Aerodromo Partida:</label>    
               <select name="aerodromo_partida">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}}> {{$aerodromo->nome}}</option>
          @endforeach    
        </select>
            </div>


                 <div>
            <label >Numero de Pessoas</label>
            <input type="number" name="num_pessoas" id="num_pessoas" value="{{$movimento->num_pessoas}}" placeholder="Numero de Pessoas" >
        </div>

            <div>
                <label for="inputNumDiario">Numero Diario</label>
                <input type="number" name="num_diario" id="inputNumDiario"  value="{{old('num_diario',$movimento->num_diario)}}" >
            </div>

            <div>
                <label for="inputServico">Numero Servico</label>
                <input type="number" name="num_servico" id="inputNumServico"  placeholder="Numero Servico" value="{{old('num_servico',$movimento->num_servico)}}">
            </div>

            <div>
                <label for="num_aterragens">Numero Aterragens</label>
                <input  type="number" name="num_aterragens" id="num_aterragens"  placeholder="Numero de Aterragens" value="{{old('num_diario',$movimento->num_servico)}}"   >
            </div>

            <div>
                <label for="inputDescolagens">Numero de Descolagens</label>
                <input type="number" name="num_descolagens" id="num_descolagens"  placeholder="Numero de Descolagens" value="{{old('num_descolagens',$movimento->num_descolagens)}}"  >
            </div>

            <div>
                <label for="inputDescolagens">Numero de Pessoas</label>
                <input type="number" name="num_pessoas" id="num_pessoas"  placeholder="Numero de Pessoas" value="{{old('num_pessoas',$movimento->num_pessoas)}}" >
            </div>

            <div>
                <label for="">Conta Horas Inicio</label>
                <input type="text" name="conta_horas_inicio" id="conta_horas_inicio"  placeholder="Conta Horas Inicio"  value="{{old('conta_horas_inicio',$movimento->conta_horas_inicio)}}" {{--onchange="precoVoo({{$aeronaves}},{{$movimentos}})"--}}>
            </div>

            <div>
                <label for="inputDescolagens">Conta Horas Fim</label>
                <input type="number" name="conta_horas_fim" id="conta_horas_fim"  placeholder="Conta Horas Fim"  value="{{old('conta_horas_fim',$movimento->conta_horas_fim)}}"  {{--onchange="precoVoo({{$aeronaves}},{{$movimentos}})"--}} >
            </div>

            <div>
                <label >Tempo de voo</label>
                <input  type="number" name="tempo_voo" id="tempo_voo"  placeholder="Tempo de Voo" value="{{old('tempo_voo',$movimento->tempo_voo)}}" >
            </div>


            {{--tempo voo e preco voo deveriam ser hidden inputs, calculados posteriormente na funcao calculos--}}



            <div>
                <label>Preço de voo</label>
                <input   type="number" name="preco_voo" id="preco_voo"  placeholder="Preço do Voo"  value="{{old('preco_voo',$movimento->preco_voo)}}"   >
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
                <input  type="number"  name="num_recibo" id="inputNumDescolagens"  placeholder="Numero de Recibo"  value="{{old('num_recibo',$movimento->num_recibo)}}"   >
            </div>


            <div>
                <label >Observacoes</label>
                <textarea name="observacoes"  rows="3" cols="50">{{$movimento->observacoes}}</textarea>
            </div>

            <div>
                <button type="submit" name="ok">Save</button>
            </div>


        <div>
          <button type="submit" name ="submit" value="confirmar">Confirmar</button>
      </div>
    </form>

  @endif


@endsection