@extends('master')
@section('content')

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

        <label>{{$movimento->hora_descolagem}}</label>
                <div></div>
                <div>Date:</div><input type="date" name="data" value={{$movimento->data}} >

         <div>Hora Descolagem:</div><input min="date" type="datetime-local" name="hora_descolagem" value={{$movimento->hora_descolagem}}> 
   
   <div>Hora Aterragem</div><input type="datetime-local" name="hora_aterragem" value={{$movimento->hora_aterragem}}>


            <br>
            <label>Natureza</label>
            <select name="natureza">
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


          @if ($movimento->natureza=='I')
        <div></div>
          <label>Tipo Instruçao</label>
          @if (is_null($movimento->tipo_instrucao))
          {{$movimento->tipo_instrucao='S'}}  <!--ver se pode ser harcoded -->  
          @endif
         
          <select name=tipo_instrucao required>
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
         @endif

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
                    Alterara para ser um botao para confirmar mais tarde
                    @if ($movimento->confirmado==1)
                        <option value=0>Por Confirmar</option>
                    @endif
                    @if ($movimento->confirmado==0)
                        <option value=1>Confirmado</option>
                    @endif
                </select>
            </div>

            <label >Socios</label>
            <select name="piloto_id">
                @foreach ($socios as $socio)
                    <option value="{{$socio->id}}" {{(  $socio->id == $movimento->piloto_id) ? 'selected' : $movimento->piloto_id }}> {{ $socio->id }}
                    </option>

                    @if ($socio->id==$socio->id)
                  {{$socioEsp=$socio}}
                    @endif


                @endforeach    </select>


            <label>{{$socioEsp->name}}</label>
<div></div>
            @if ($movimento->natureza=='I')
                <label >Instrutor</label>
                <select name="instrutor_id">
                    @foreach ($socios as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$socio->id}}" {{(  $socio->id == $movimento->instrutor_id) ? 'selected' : $movimento->instrutor_id }}> {{ $socio->id }}
                    </option>
                        @endif


                    @if ($socio->id==$movimento->instrutor_id)
                        {{$instrutorEsp=$socio}}
                        @endif
                    @endforeach    </select>

            @endif

            @if(!is_null($instrutorEsp))
            <label>{{$instrutorEsp->name}}</label>
            @endif




       

        <div>
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

  


@endsection