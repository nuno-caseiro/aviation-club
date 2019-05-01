@extends('master')
@section('content')

    <form action="{{action('AeronaveController@update', $aeronave->matricula)}}" method="post">
        @method('put')
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
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

    @endsection
