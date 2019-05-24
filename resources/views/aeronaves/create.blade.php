@extends('layouts.app')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif

    <form method="POST" action="{{action('AeronaveController@store')}}" >
        @method("POST")
        @csrf
        <div>
            <label for="inputMatricula">Matricula</label>
            <input type="text" name="matricula" id="inputMatricula"  placeholder="Matricula" >
        </div>
        <div>
            <label for="inputMarca">Marca</label>
            <input type="text" name="marca" id="inputMarca"  placeholder="Marca" >
        </div>
        <div>
            <label for="inputModelo">Modelo</label>
            <input type="text" name="modelo" id="inputModelo"  placeholder="Modelo" >
        </div>
        <div>
            <label for="inputNrLugares">Numero de lugares</label>
            <input type="text" name="num_lugares" id="inputNrLugares"  placeholder="Numerolugares" >
        </div>

        <div>
            <label for="inputContaHoras">Conta horas</label>
            <input type="text" name="conta_horas" id="inputContaHoras" placeholder="Conta horas" >
        </div>
        <div>
            <label for="inputPrecoHora">Preco hora</label>
            <input type="text" name="preco_hora" id="inputPrecoHora"  placeholder="Preco hora" >
        </div>

        <div>
            <button type="submit" name="ok">Save</button>
        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>Unidade conta horas</th>
                    <th>Minutos</th>
                    <th>Preco</th>
                </tr>
                </thead>

                <tbody>
                @for($i=1; $i<=10; $i++)
                    <tr>
                        <th>{{$i}}</th>
                        <th> <input type="text" name="tempos[{{$i}}]" id="inputMinuto" value="" placeholder="" >    </th>
                        <th> <input type="text" name="precos[{{$i}}]" id="inputPreco" value="" placeholder="" >    </th>

                    </tr>

                @endfor

                </tbody>
            </table>

        </div>
    </form>

@endsection
