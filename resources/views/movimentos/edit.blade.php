@extends('master')
@section('content')

    <form action="{{action('MovimentoController@update', $movimento->id)}}" method="post" >
        @method('put')
        @csrf 
<script>
function myFunction() {
var selectedValue=document.getElementById("natureza").value;
if(selectedValue != "I") {
    document.getElementById("instrutor_id").style="display: none;"
    document.getElementById("instrutor_label").style="display: none;"
    document.getElementById("instrutorEsp").style="display: none;"
    document.getElementById("tipo_instrucao").style="display: none;"
    document.getElementById("tipo_instrucao_select").style="display: none;"
     document.getElementById("instrutor_id").value=null;
    document.getElementById("instrutor_label").value=null;
    document.getElementById("instrutorEsp").value=null;
    document.getElementById("tipo_instrucao").value=null;
    document.getElementById("tipo_instrucao_select").value=null;
       document.getElementById("instrutor_label").value=null;
}else{
   document.getElementById("instrutor_id").style="display: ?;"
    document.getElementById("instrutor_label").style="display: ?;"
    document.getElementById("instrutorEsp").style="display: ?;"
    document.getElementById("tipo_instrucao").style="display: ?;"
    document.getElementById("tipo_instrucao_select").style="display: ?;"

}
}
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
  if(selectedValue==value){
    document.getElementById("instrutorEsp").innerHTML=element.name;
  }
    if(selectedValue==""){
    document.getElementById("instrutorEsp").innerHTML="";
  }
});

}
</script>
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
            <select name="natureza" id="natureza" onchange="myFunction();">
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
          @if (is_null($movimento->tipo_instrucao))
          {{$movimento->tipo_instrucao='S'}}  <!--ver se pode ser harcoded -->  
          @endif
         
          <select id="tipo_instrucao_select" name=tipo_instrucao required>
            <option value="{{$movimento->tipo_instrucao}}">@if($movimento->tipo_instrucao=='D')
                       Duplo  
                  @endif
                    @if ($movimento->tipo_instrucao=='S')
                        Solo
                    @endif
                </option>
                 @if ($movimento->tipo_instrucao=='D')
                <option value="S"> 
                        Solo
                  </option>  @endif
                  @if($movimento->tipo_instrucao=='S')
                    <option value="D">
                        Duplo
                   </option> @endif

          </select>
 

            <div>
                <label for="input">Estado</label>
                <select name=confirmado>
                    <option value="{{ $movimento->confirmado}}">@if($movimento->confirmado==1)
                            Confirmado
                        @endif
                        @if ($movimento->confirmado==0)
                            Por Confirmar
                        @endif
                    </option>
                    @if ($movimento->confirmado==1)
                        <option value=0>Por Confirmar</option>
                    @endif
                    @if ($movimento->confirmado==0)
                        <option value=1>Confirmado</option>
                    @endif
                </select>
            </div>

            <label >Socios</label>
            <select name="piloto_id" id="socio" onchange="myLabelsSocio({{$socios}})">
                <option></option>
                @foreach ($socios as $socio)
                    <option value="{{$socio->id}}" {{(  $socio->id == $movimento->piloto_id) ? 'selected' : $movimento->piloto_id }}> {{ $socio->id }}
                    </option>

                    @if ($socio->id==$movimento->piloto_id)
                  {{$socioEsp=$socio}}
                    @endif


                @endforeach    </select>


            <label id="socioName">{{$socioEsp->name}}</label>
<div></div>
        
                <label id="instrutor_label" >Instrutor</label>
                <select name="instrutor_id" id="instrutor_id" onchange="myLabelsInstrutor({{$socios}})" >
                    <option></option>
                    @foreach ($socios as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$socio->id}}" {{(  $socio->id == $movimento->instrutor_id) ? 'selected' : $movimento->instrutor_id }}> {{ $socio->id }}
                    </option>
                        @endif


                    @if ($socio->id==$movimento->instrutor_id)
                        {{$instrutorEsp=$socio}}
                        @endif
                    @endforeach    </select>


            <label id="instrutorEsp">{{$instrutorEsp->name}}</label>




       

        <div>
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

  


@endsection