
@extends('layouts.app')
@section('content')








<h1>Tabela Movimentos Com Conflitos</h1>

<table class="table table-striped table-bordered" style="width: 50%">
        <thead>
        <tr >

            <th></th>
            <th>Data</th>
            <th>Hora Descolagem</th>
            <th>Hora Aterragem</th>
            @cannot('normal_ativo', Auth::id())
                <th>Aeronave</th>
            @endcannot
            @cannot('normal_ativo', Auth::id())
                <th>Piloto </th>
            @endcannot
            <th>Natureza</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Numero Pessoas</th>
            <th>Conta Horas Inicio</th>
            <th>Conta Horas Fim</th>
            @cannot('normal_ativo', Auth::id())
                <th>Tempo de Voo</th>
                <th>Preço Voo</th>
            @endcannot
            <th>Confirmado</th>
            <th>Tipo Instrucao</th>
            <th>Instrutor</th>
            <th>Numero Aterragens</th>
            <th>Numero Descolagens</th>
            <th>Numero Servico</th>
            <th>Numero Diario</th>
            <th>Tipo Conflito</th>
            <th>Razao Conflito</th>
        </tr>
        </thead>

        <tbody>
        @foreach($movimentosComConflitos as $movimento)
            <tr @if ($movimento->tipo_conflito=='B')  class="table-warning"     @endif      @if($movimento->tipo_conflito=='S') class="table-danger"   @endif>
                <td><a href="movimentos/{{$movimento->id}}/edit">{{$movimento->id}}</a></td>
                <td>{{$movimento->data}}</td>
                <td>{{$movimento->hora_descolagem}}</td>
                <td>{{$movimento->hora_aterragem}}</td>
                @cannot('normal_ativo', Auth::id())
                    <td>{{$movimento->aeronave}}</td>
                @endcannot
                @foreach($users as $user)
                    @if($movimento->piloto_id== $user->id)
                        <td>{{$user->nome_informal}}</td>
                    @endif
                @endforeach
                @cannot('normal_ativo', Auth::id())

                    @if ($movimento->natureza=='E')   <td>Especial</td> @endif
                    @if ($movimento->natureza=='T')     <td>Treino</td> @endif
                    @if ($movimento->natureza=='I')  <td>Instrução</td> @endif

                @endcannot

         
                  
                        <td> {{$movimento->aerodromo_partida}}</td>
               
                        <td>{{$movimento->aerodromo_chegada}}</td>
              

                <td>{{$movimento->num_pessoas}}</td>
                <td>{{$movimento->conta_horas_inicio}}</td>
                <td>{{$movimento->conta_horas_fim}}</td>
                @cannot('normal_ativo', Auth::id())
                    <td>{{$movimento->tempo_voo}}</td>
                    <td>{{$movimento->preco_voo}}</td>

                @endcannot

                @if($movimento->confirmado=='1')
                    <td> Confirmado</td>
                @else
                    <td>Por Confirmar</td>
                @endif


                @if ($movimento->tipo_instrucao=='D')  <td>Duplo</td> @endif
                @if ($movimento->tipo_instrucao=='S')  <td>Simples</td> @endif
                @if (is_null($movimento->tipo_instrucao))  <td>-</td> @endif


                @if (is_null($movimento->instrutor_id))  <td>-</td> @endif
                @foreach($users as $user)
                    @if($movimento->instrutor_id== $user->id  )
                        <td>{{$user->nome_informal}}</td>
                    @endif

                @endforeach


                <td>{{$movimento->num_aterragens}}</td>
                <td>{{$movimento->num_descolagens}}</td>
                <td>{{$movimento->num_servico}}</td>
                <td>{{$movimento->num_diario}}</td>
                <td>@if($movimento->tipo_conflito!=null)
                  {{$movimento->tipo_conflito}}
                  @else
                  -
                  @endif
                </td>
              <td>@if($movimento->justificao_conflito!=null)
                  {{$movimento->justificacao_conflito}}
                  @else
                  -



                  @endif



                    </tr>
        @endforeach

        </tbody>
    </table>









<h1>Tabela Movimentos Com Movimentos Por Comfirmar</h1>

<table class="table table-striped table-bordered" style="width: 50%">
        <thead>
        <tr >

            <th></th>
            <th>Data</th>
            <th>Hora Descolagem</th>
            <th>Hora Aterragem</th>
            @cannot('normal_ativo', Auth::id())
                <th>Aeronave</th>
            @endcannot
            @cannot('normal_ativo', Auth::id())
                <th>Piloto </th>
            @endcannot
            <th>Natureza</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Numero Pessoas</th>
            <th>Conta Horas Inicio</th>
            <th>Conta Horas Fim</th>
            @cannot('normal_ativo', Auth::id())
                <th>Tempo de Voo</th>
                <th>Preço Voo</th>
            @endcannot
            <th>Confirmado</th>
            <th>Tipo Instrucao</th>
            <th>Instrutor</th>
            <th>Numero Aterragens</th>
            <th>Numero Descolagens</th>
            <th>Numero Servico</th>
            <th>Numero Diario</th>
            <th>Tipo Conflito</th>
            <th>Razao Conflito</th>
        </tr>
        </thead>

        <tbody>
        @foreach($movimentosPorConfirmar as $movimento)
            <tr @if ($movimento->tipo_conflito=='B')  class="table-warning"     @endif      @if($movimento->tipo_conflito=='S') class="table-danger"   @endif>
                <td><a href="movimentos/{{$movimento->id}}/edit">{{$movimento->id}}</a></td>
                <td>{{$movimento->data}}</td>
                <td>{{$movimento->hora_descolagem}}</td>
                <td>{{$movimento->hora_aterragem}}</td>
                @cannot('normal_ativo', Auth::id())
                    <td>{{$movimento->aeronave}}</td>
                @endcannot
                @foreach($users as $user)
                    @if($movimento->piloto_id== $user->id)
                        <td>{{$user->nome_informal}}</td>
                    @endif
                @endforeach
                @cannot('normal_ativo', Auth::id())

                    @if ($movimento->natureza=='E')   <td>Especial</td> @endif
                    @if ($movimento->natureza=='T')     <td>Treino</td> @endif
                    @if ($movimento->natureza=='I')  <td>Instrução</td> @endif

                @endcannot

         
                  
                        <td> {{$movimento->aerodromo_partida}}</td>
               
                        <td>{{$movimento->aerodromo_chegada}}</td>
              

                <td>{{$movimento->num_pessoas}}</td>
                <td>{{$movimento->conta_horas_inicio}}</td>
                <td>{{$movimento->conta_horas_fim}}</td>
                @cannot('normal_ativo', Auth::id())
                    <td>{{$movimento->tempo_voo}}</td>
                    <td>{{$movimento->preco_voo}}</td>

                @endcannot

                @if($movimento->confirmado=='1')
                    <td> Confirmado</td>
                @else
                    <td>Por Confirmar</td>
                @endif


                @if ($movimento->tipo_instrucao=='D')  <td>Duplo</td> @endif
                @if ($movimento->tipo_instrucao=='S')  <td>Simples</td> @endif
                @if (is_null($movimento->tipo_instrucao))  <td>-</td> @endif


                @if (is_null($movimento->instrutor_id))  <td>-</td> @endif
                @foreach($users as $user)
                    @if($movimento->instrutor_id== $user->id  )
                        <td>{{$user->nome_informal}}</td>
                    @endif

                @endforeach


                <td>{{$movimento->num_aterragens}}</td>
                <td>{{$movimento->num_descolagens}}</td>
                <td>{{$movimento->num_servico}}</td>
                <td>{{$movimento->num_diario}}</td>
                <td>@if($movimento->tipo_conflito!=null)
                  {{$movimento->tipo_conflito}}
                  @else
                  -
                  @endif
                </td>
              <td>@if($movimento->justificao_conflito!=null)
                  {{$movimento->justificacao_conflito}}
                  @else
                  -



                  @endif



                    </tr>
        @endforeach

        </tbody>
    </table>






<H1>Tabela Certificados Por Validar User</H1>

<table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
    <thead>
    <tr>
        <th>Nome User</th>
        <th>Número do certificado</th>
        <th>Classe do certificado</th>
        <th>Validade do certificado</th>
        <th>Confirmação do certificado</th>
    </tr>
    </thead>
    @foreach ($usersComCertificadosPorValidar as $user)

    <thead>
    <tr>
        <td><a href="pilotos/{{$user->id}}/certificado">{{$user->name}}</a></td>
        <td>{{ $user->num_certificado}}</td>
        <td>{{ $user->classe_certificado}}</td>
        <td>{{ $user->validade_certificado}}</td>
        <td>{{ $user->certificado_confirmado}}</td>


    </tr>

    </thead>
@endforeach

</table>




<H1>Tabela Licensas Por Validar User</H1>

<table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
    <thead>

    <tr>
        <th>Nome User</th>
        <th>Número de Licença</th>
        <th>Tipo de Licença</th>
        <th>Instrutor</th>
        <th>Validade de licença</th>
        <th>Confirmação de licença</th>



    </tr>
    </thead>
    @foreach ($usersComLicencasPorValidar as $user)

        <thead>

        <tr>
            <td><a href="pilotos/{{$user->id}}/licenca">{{$user->name}}</a></td>
            <td>{{ $user->num_licenca }}</td>
            <td>{{ $user->tipo_licenca }}</td>
            <td>{{ $user->instrutor}}</td>
            <td>{{ $user->validade_licenca}}</td>
            <td>{{ $user->licenca_confirmada}}</td>


        </tr>

        </thead>

@endforeach


</table>


























































@endsection
