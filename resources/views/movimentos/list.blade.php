@extends('master')
@section('content')

    <h4>Tabela de Movimentos</h4>

   <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
      

     <legend>Filtrar Movimentos:</legend>
        Aeronaves:<br>


:id, aeronave, data_inf, data_sup, natureza, confirmado,
piloto, instrutor, meus_movimentos.
      




          <form method="GET" action="{{action('MovimentoController@index')}}">


        <label>Movimento ID:</label>
       <input type="number"  name="movimento_id"></input>
      <div></div>






                  <label>Aeronaves</label>
                 <select name="aeronave">
                   <option></option>
                @foreach ($aeronaves as $aeronave)
                    <option value="{{ $aeronave->matricula }}"> {{ $aeronave->matricula }} </option>
                @endforeach    </select>
<div></div>

<label>Natureza</label>
<input type="checkbox" name="naturezaI" value=I> <label>Instrução</label>
<input type="checkbox" name="naturezaT" value=T> <label>Treino</label>
<input type="checkbox" name="naturezaE" value=E> <label>Especial</label>


<div></div>
              <label>Cofirmado:</label>
                <input type="radio" name="confirmado" value="1"><label for="confirmado" class="light">Confirmado</label>
                <input type="radio" name="confirmado" value="0"><label for="Confirmar" class="light">Por Confirmar</label>
<div></div>

 
<label >Socios</label>
            <select name="piloto">
              <option></option>
                @foreach ($users as $socio)
                    <option value="{{$socio->id}}"> {{ $socio->id }}
           </option>
 @endforeach    
</select>

  
   <label >Instrutor</label>
                <select name="instrutor">
                  <option></option>
                    @foreach ($users as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$socio->id}}"> {{ $socio->id }}</option>
                        @endif
                    @endforeach

          </select>

<label>Hora:</label>
<input type="datetime-local" name="descolar">
<input type="datetime-local" name="aterrar">






        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-5">
                <br>
                <button type="submit" class="btn btn-primary">
                    {{ __('Aplicar filtro') }}
                </button>
            </div>
        </div>
      </form>





       <thead>
           <tr>

               <th>ID</th>
               <th>Data</th>
               <th>Hora Descolagem</th>
               <th>Hora Aterragem</th>
             @cannot('normal_ativo', Auth::id())
               <th>Aeronave</th>
               @endcannot
               <th>Numero Diario</th>
               <th>Numero Servico</th>
               <th>Piloto </th>
                @cannot('normal_ativo', Auth::id())
               <th>Numero Licensa do piloto</th>
               <th>Validade Licensa Piloto</th>
               <th>Tipo Licensa Piloto</th>
               <th>Numero Certificado Piloto </th>
               <th>Validade Certificado Pilot</th>
               <th>Classe Certificado Piloto</th> 
               <th>Natureza</th>
                @endcannot
               <th>Aerodromo Partida</th>
               <th>Aerodromo Chegada</th>
               <th>Numero Aterragens</th>
               <th>Numero Descolagens</th>
               <th>Numero Pessoas</th>
               <th>Conta Horas Inicio</th>
               <th>Conta Horas Fim</th>
              @cannot('normal_ativo', Auth::id())
               <th>Tempo de Voo</th>
               <th>Preço Voo</th>
               <th>Modo de pagamento</th>
               <th>Numero Recibo</th>
                 @endcannot
               <th>Observacoes</th>
               <th>Confirmado</th>
               <th>Tipo Instrucao</th>
               <th>Instrutor</th>
                @cannot('normal_ativo', Auth::id())
               <th>Numero Licenca Instrutor</th>
               <th>Validade Lincensa Instrutor</th>
               <th>Tipo Lincesa Instrutor</th>
               <th>Numero Certificado Instrutor</th>
               <th>Validade Certificado Instrutor</th>
               <th>Classe certificado Instrutor</th>
               <th>Criado A</th>
               <th>Updated a</th>
              @endcannot

           </tr>
       </thead>
       @foreach($movimentos as $movimento)
           <tr>
               <td>{{$movimento->id}}</td>
               <td>{{$movimento->data}}</td>
               <td>{{$movimento->hora_descolagem}}</td>
               <td>{{$movimento->hora_aterragem}}</td>
               @cannot('normal_ativo', Auth::id())
               <td>{{$movimento->aeronave}}</td>
               @endcannot
               <td>{{$movimento->num_diario}}</td>
               <td>{{$movimento->num_servico}}</td>
               @foreach($users as $user)
                   @if($movimento->piloto_id== $user->id)
               <td>{{$user->nome_informal}}</td>
                   @endif
               @endforeach
               @cannot('normal_ativo', Auth::id())
               <td>{{$movimento->num_licenca_piloto}}</td>
               <td>{{$movimento->validade_licenca_piloto}}</td>
               <td>{{$movimento->tipo_licenca_piloto}}</td>
               <td>{{$movimento->num_certificado_piloto}}</td>
               <td>{{$movimento->validade_certificado_piloto}}</td>
               <td>{{$movimento->classe_certificado_piloto}}</td>
               <td>{{$movimento->natureza}}</td>
               @endcannot
               <td>{{$movimento->aerodromo_partida}}</td>
               <td>{{$movimento->aerodromo_chegada}}</td>
               <td>{{$movimento->num_aterragens}}</td>
               <td>{{$movimento->num_descolagens}}</td>
               <td>{{$movimento->num_pessoas}}</td>
               <td>{{$movimento->conta_horas_inicio}}</td>
               <td>{{$movimento->conta_horas_fim}}</td>
               @cannot('normal_ativo', Auth::id())
               <td>{{$movimento->tempo_voo}}</td>
               <td>{{$movimento->preco_voo}}</td>
               <td>{{$movimento->modo_pagamento}}</td>
               <td>{{$movimento->num_recibo}}</td>
               @endcannot
               <td>{{$movimento->observacoes}}</td>
               <td>{{$movimento->confirmado}}</td>
               <td>{{$movimento->tipo_instrucao}}</td>
               @foreach($users as $user)
                   @if($movimento->instrutor_id== $user->id  )
                       <td>{{$user->nome_informal}}</td>
                   @endif
               @endforeach
               @foreach($users as $user)
                   @if($movimento->instrutor_id== ""  )
                       <td></td>
                       @break
                   @endif
               @endforeach
               @cannot('normal_ativo', Auth::id())
               <td>{{$movimento->num_licenca_instrutor}}</td>
               <td>{{$movimento->validade_licenca_instrutor}}</td>
               <td>{{$movimento->tipo_licenca_instrutor}}</td>
               <td>{{$movimento->num_certificado_instrutor}}</td>
               <td>{{$movimento->validade_certificado_instrutor}}</td>  
               <td>{{$movimento->classe_certificado_instrutor}}</td>    
               <td>{{$movimento->created_at}}</td>    
               <td>{{$movimento->updated_at}}</td>
               @endcannot
                <td><a class="btn btn-xs btn-primary" href="{{ action('MovimentoController@edit', $movimento->id) }}">Edit</a></td>
               <td><form action="{{ action('MovimentoController@destroy', $movimento->id) }}"
                     method="post">
                   @csrf
                   @method('delete')
                   <input type="hidden" name="id" value="{{$movimento->id}}">
                   <input type="submit" value="Delete">
               </form>
           </tr>
           @endforeach

          </table>
          
    <div class="text-center">
      {!! $movimentos->links(); !!}
    </div>
         <a href="{{ action('MovimentoController@create') }}"class="btn btn-primary">Adicionar Movimento</a>
    @endsection