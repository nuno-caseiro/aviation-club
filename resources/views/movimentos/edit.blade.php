@extends('layouts.app')
@section('content')


    @if (count($errors) > 0)
        @include('shared.errors')
    @endif

<!--perguntar ao nuno como por em acess forbidden nao quero assim

    @can(Auth::user()->can('isDirecao', Auth::user()) || (auth()->user()->id==$movimento->piloto_id) || (auth()->user()->id==$movimento->instrutor_id)) 
  @endcan


-->

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

    <form action="{{action('MovimentoController@update', $movimento->id)}}" method="post" >
        @method('put')
        @csrf 



{{$instrutorEsp=null}}
{{$socioEsp=null}}
        <div class="card-header">Editar Movimento</div>
        <div>
            <label >Aeronave</label>
            <select name="aeronave">
                @foreach ($aeronaves as $aeronave)
                    <option value="{{ $aeronave->matricula }}" {{ ( $aeronave->matricula == $movimento->aeronave) ? 'selected' : $movimento->aeronave }}> {{ $aeronave->matricula }} </option>
                @endforeach    </select>

        
                <div></div>
                <div>Date:</div><input type="date" name="data" value={{$movimento->data}} >

         <div>Hora Descolagem:</div><input min="date" type="datetime-local" name="hora_descolagem" value={{$movimento->hora_descolagem}}> 
   
   <div>Hora Aterragem</div><input type="datetime-local" name="hora_aterragem" value={{$movimento->hora_aterragem}}>


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


         
        <div></div>
          <label id='tipo_instrucao'>Tipo Instruçao</label>     
          <select id="tipo_instrucao_select" name="tipo_instrucao" required>
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
          <div></div>


            <div>
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
          
<div></div>
             
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
                    @endforeach    </select>
                
            
            <label  id="instrutorEsp">{{$instrutorEsp}}</label>
    
<br>
               <label> Aerodromo Chegada:</label>    
               <select name="aerodromo_chegada">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}} > {{$aerodromo->nome}}</option>
          @endforeach       
        </select>       



<div></div>
  <label> Aerodromo Partida:</label>    
               <select name="aerodromo_partida">
              <option></option>
                @foreach ($aerodromos as $aerodromo)
                      <option value="{{$aerodromo->code}}"  {{(  $aerodromo->code == $movimento->aerodromo_partida) ? 'selected' : $movimento->aerodromo_partida}}> {{$aerodromo->nome}}</option>
          @endforeach    
        </select>    



                 <div>
            <label >Numero de Pessoas</label>
            <input type="number" name="num_pessoas" id="num_pessoas" value={{$movimento->num_pessoas}} placeholder="Numero de Pessoas" >
        </div>


       

        <div>
            <button type="submit" name="ok">Save</button>
        </div>

        <!-- @can(Auth::user()->can('isDirecao', Auth::user()))
        <button type="submit" name = "submit" value = "confirmar">Confirmar</button>
        @endcan so os da direcao e que teem esta opcao-->

        <div>
          <button type="submit" name ="submit" value="confirmar">Confirmar</button>
      </div>
    </form>

  @endif


@endsection