@extends('master')
@section('content')

    <h4>Tabela de Movimentos</h4>

   <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
       <thead>
           <tr>
               <th>ID</th>
               <th>Data</th>
               <th>Hora Descolagem</th>
               <th>Hora Aterragem</th>
               <th>Aeronave</th>
               <th>Numero Diario</th>
               <th>Numero Servico</th>
               <th>Piloto ID</th>
               <th>Numero Licensa do piloto</th>
               <th>Validade Licensa Piloto</th>
               <th>Tipo Licensa Piloto</th>
               <th>Numero Certificado Piloto </th>
               <th>Validade Certificado Pilot</th>
               <th>Classe Certificado Piloto</th> 
               <th>Natureza</th>
               <th>Aerodromo Partida</th>
               <th>Aerodromo Chegada</th>
               <th>Numero Aterragens</th>
               <th>Numero Descolagens</th>
               <th>Numero Pessoas</th>
               <th>Conta Horas Inicio</th>
               <th>Conta Horas Fim</th>
               <th>Tempo de Voo</th>
               <th>Preço Voo</th>
               <th>Modo de pagamento</th>
               <th>Numero Recibo</th>
               <th>Observacoes</th>
               <th>Confirmado</th>
               <th>Tipo Instrucao</th>
               <th>Instrutor ID</th>
               <th>Numero Licenca Instrutor</th>
               <th>Validade Lincensa Instrutor</th>
               <th>Tipo Lincesa Instrutor</th>
               <th>Numero Certificado Instrutor</th>
               <th>Validade Certificado Instrutor</th>
               <th>Classe certificado Instrutor</th>
               <th>Criado A</th>
               <th>Updated a</th>
            






           </tr>
       </thead>
       @foreach($movimentos as $movimento)
           <tr>
               <td>{{$movimento->id}}</td>
               <td>{{$movimento->data}}</td>
               <td>{{$movimento->hora_descolagem}}</td>
               <td>{{$movimento->hora_aterragem}}</td>
               <td>{{$movimento->aeronave}}</td>
               <td>{{$movimento->num_diario}}</td>
               <td>{{$movimento->num_servico}}</td>
               <td>{{$movimento->piloto_id}}</td>
               <td>{{$movimento->num_licenca_piloto}}</td>
               <td>{{$movimento->validade_licenca_piloto}}</td>
               <td>{{$movimento->tipo_licenca_piloto}}</td>
               <td>{{$movimento->num_certificado_piloto}}</td>
               <td>{{$movimento->validade_certificado_piloto}}</td>
               <td>{{$movimento->classe_certificado_piloto}}</td>
               <td>{{$movimento->natureza}}</td>
               <td>{{$movimento->aerodromo_partida}}</td>
               <td>{{$movimento->aerodromo_chegada}}</td>
               <td>{{$movimento->num_aterragens}}</td>
               <td>{{$movimento->num_descolagens}}</td>
               <td>{{$movimento->num_pessoas}}</td>
               <td>{{$movimento->conta_horas_inicio}}</td>
               <td>{{$movimento->conta_horas_fim}}</td>
               <td>{{$movimento->tempo_voo}}</td>
               <td>{{$movimento->preco_voo}}</td>
               <td>{{$movimento->modo_pagamento}}</td>
               <td>{{$movimento->num_recibo}}</td>
               <td>{{$movimento->observacoes}}</td>
               <td>{{$movimento->confirmado}}</td>
               <td>{{$movimento->tipo_instrucao}}</td>
               <td>{{$movimento->instrutor_id}}</td>
               <td>{{$movimento->num_licenca_instrutor}}</td>
               <td>{{$movimento->validade_licenca_instrutor}}</td>
               <td>{{$movimento->tipo_licenca_instrutor}}</td>
               <td>{{$movimento->num_certificado_instrutor}}</td>
               <td>{{$movimento->validade_certificado_instrutor}}</td>  
               <td>{{$movimento->classe_certificado_instrutor}}</td>    
               <td>{{$movimento->created_at}}</td>    
               <td>{{$movimento->updated_at}}</td>       
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



     

           </script>

          </table>
          
    <div class="text-center">
      {!! $movimentos->links(); !!} 
    </div>
         <a href="{{ action('MovimentoController@create') }}"class="btn btn-primary">Adicionar Movimento</a>
    @endsection