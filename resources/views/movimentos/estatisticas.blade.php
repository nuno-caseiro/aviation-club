@extends('layouts.app')
@section('content')





    <div class="card-header">{{ __('Estatisticas Grafico') }}</div>

    <form action="{{route('movimentos.estatisticas')}}" method="GET">
        <div class="card-body">
            Total de horas por
            <select name = "Xaxis" value="{{Request::input('Xaxis')}}" required>
                <option  value="Ano" selected>Ano</option>
                <option  value="Mes">Mês</option>
            </select>
            da/do
            <select name = "Yaxis" value="{{Request::input('Yaxis')}}" required>
                <option  value="Aeronave" selected>Aeronave</option>
                <option  value="Piloto">Piloto</option>
            </select>
            <input type="text" id="myInput1" size="40" name="Nome" placeholder="Matricula Aeronave / Nome Informal do Piloto..." value="{{Request::input('Nome')}}" required>
            <button type="submit" class="btn btn-primary">Make Graph</button>
        </div>
    </form>

    <div class="card-body">

        @if($chart != null)
            {!! $chart->render() !!}

        @endif
    </div>

{{--
    <div class="card-header">{{ __('Estatisticas Total de horas por Ano das aeronaves') }}</div>
    <div class="table-responsive">
        <table id="tabela_paginada" class="table table-striped">

            <thead>
            <tr class="bg-info">
                <th>Matricula Aeronave</th>
                @foreach ($datas_ano as $data)
                    <th>{{$data->date}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($movimentos_A_A as $movimento)
                <tr>
                    <th>{{$movimento[0]}}</th>
                    @php
                        foreach($datas_ano as $data) {
                            $aux = $data->date;
                            if(array_key_exists($aux, $movimento)){
                                echo  "<td> $movimento[$aux] </td>";
                            }else{
                                echo "<td>---</td>";
                            }
                        }
                    @endphp
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


    <div class="card-header">{{ __('Estatisticas Total de horas por Ano dos Pilotos') }}</div>
    <div class="table-responsive">
        <table id="tabela_paginada"class="table table-striped">

            <thead>
            <tr class="bg-info">
                <th>Piloto</th>
                @foreach ($datas_ano as $data)
                    <th>{{$data->date}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($movimentos_P_A as $movimento)
                @php
                    $nome = User::where('id', '=', $movimento[0])->first()->nome_informal;
                @endphp
                <tr>
                    <th>{{$nome}}</th>
                    @php
                        foreach($datas_ano as $data) {
                            $aux = $data->date;
                            if(array_key_exists($aux, $movimento)){
                                echo  "<td> $movimento[$aux] </td>";
                            }else{
                                echo "<td>---</td>";
                            }
                        }
                    @endphp
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>


    <div class="card-header">{{ __('Estatisticas Total de horas por mês das aeronaves') }}</div>
    <div class="table-responsive">
        <table id="tabela_paginada" class="table table-striped">

            <thead>
            <tr class="bg-info">
                <th>Matricula Aeronave</th>
                @foreach ($datas_mes as $data)
                    <th>{{$data->date}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($movimentos_A_M as $movimento)
                <tr>
                    <th>{{$movimento[0]}}</th>
                    @php
                        foreach($datas_mes as $data) {
                            $aux = $data->date;
                            if(array_key_exists($aux, $movimento)){
                                echo  "<td> $movimento[$aux] </td>";
                            }else{
                                echo "<td>---</td>";
                            }
                        }
                    @endphp
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>



    <div class="card-header">{{ __('Estatisticas Total de horas por Mes dos Pilotos') }}</div>
    <div class="table-responsive">
        <table id="tabela_paginada"class="table table-striped">

            <thead>
            <tr class="bg-info">
                <th>Piloto</th>
                @foreach ($datas_mes as $data)
                    <th>{{$data->date}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach ($movimentos_P_M as $movimento)
                @php
                    $nome = User::where('id', '=', $movimento[0])->first()->nome_informal;
                @endphp
                <tr>
                    <th>{{$nome}}</th>
                    @php
                        foreach($datas_mes as $data) {
                            $aux = $data->date;
                            if(array_key_exists($aux, $movimento)){
                                echo  "<td> $movimento[$aux] </td>";
                            }else{
                                echo "<td>---</td>";
                            }
                        }
                    @endphp
                </tr>
            @endforeach
            </tbody>


        </table>
    </div>


--}}
@endsection