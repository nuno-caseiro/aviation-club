@extends('master')
@section('content')

    <form action="{{action('AeronaveController@store')}}" method="post">
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
            <button type="submit" name="ok">Save</button>
        </div>
    </form>

@endsection
