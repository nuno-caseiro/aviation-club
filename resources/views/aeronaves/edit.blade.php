@extends('master')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif

    <form method="POST" action="{{action('AeronaveController@update', $aeronave->matricula)}}" >
        @method('PUT')
        @csrf
        <div>
            <label for="inputMatricula">Matricula</label>
            <input type="text" name="matricula" id="inputMatricula" value="{{ $aeronave->matricula }}" placeholder="Matricula" >
        </div>
        <div>
            <label for="inputMarca">Marca</label>
            <input type="text" name="marca" id="inputMarca" value="{{ $aeronave->marca }}" placeholder="Marca" >
        </div>
        <div>
            <label for="inputModelo">Modelo</label>
            <input type="text" name="modelo" id="inputModelo" value="{{ $aeronave->modelo }}" placeholder="Modelo" >
        </div>
        <div>
            <label for="inputNrLugares">Numero de lugares</label>
            <input type="text" name="num_lugares" id="inputNrLugares" value="{{ $aeronave->num_lugares }}" placeholder="Numero de lugares" >
        </div>
        <div>
            <label for="inputContaHoras">Conta horas</label>
            <input type="text" name="conta_horas" id="inputContaHoras" value="{{ $aeronave->conta_horas }}" placeholder="Conta horas" >
        </div>
        <div>
            <label for="inputPrecoHora">Preco hora</label>
            <input type="text" name="preco_hora" id="inputPrecoHora" value="{{ $aeronave->preco_hora }}" placeholder="Preco hora" >
        </div>
        <div>
            @can('socio_Direcao',  Auth::user())
            <table class="table">
                <thead>
                <tr>
                    <th>Unidade conta horas</th>
                    <th>Minutos</th>
                    <th>Preco</th>
                </tr>
                </thead>

                <tbody>
                @for($i=1; $i<=count($aeronaveValores); $i++)
                    <tr>
                        <th>{{$aeronaveValores[$i-1]['unidade_conta_horas']}}</th>
                        <th> <input type="text" name="tempos[{{$i}}]" id="inputMinuto" value="{{$aeronaveValores[$i-1]['minutos']}}" placeholder={{$aeronaveValores[$i-1]['minutos']}} >    </th>
                        <th> <input type="text" name="precos[{{$i}}]" id="inputPreco" value="{{$aeronaveValores[$i-1]['preco']}}" placeholder={{$aeronaveValores[$i-1]['preco']}} >    </th>

                    </tr>

                @endfor

                </tbody>
            </table>
            @endcan
        </div>


        <div>
            <button class="btn btn-xs btn-primary" type="submit" name="ok">Save</button>

        </div>
    </form>

    @endsection
