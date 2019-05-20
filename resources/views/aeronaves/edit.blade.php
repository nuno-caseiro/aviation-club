@extends('master')
@section('content')

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
            <input type="text" name="nrlugares" id="inputNrLugares" value="{{ $aeronave->num_lugares }}" placeholder="Numero de lugares" >
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
                @for($i=0; $i<=count($aeronaveValores)-1; $i++)
                    <tr>
                        <th>{{$aeronaveValores[$i]['unidade_conta_horas']}}</th>
                        <th> <input type="text" name="minutos[]" id="inputMinuto" value="{{$aeronaveValores[$i]['minutos']}}" placeholder={{$aeronaveValores[$i]['minutos']}} >    </th>
                        <th> <input type="text" name="precos[]" id="inputPreco" value="{{$aeronaveValores[$i]['preco']}}" placeholder={{$aeronaveValores[$i]['preco']}} >    </th>

                    </tr>

                @endfor

                </tbody>
            </table>
            @endcan
        </div>


        <div>
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

    @endsection
