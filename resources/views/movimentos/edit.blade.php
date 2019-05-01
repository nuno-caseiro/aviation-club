@extends('master')
@section('content')

    <form action="{{action('MovimentoController@update', $movimento->id)}}" method="post">
        @method('put')
        @csrf
        <div>
            <label for="inputID">ID</label>
            <input type="text" name="id" id="inputID" value="{{ $movimento->id }}" placeholder="id" >
        </div>
        <div>

            protected $fillable = ['id', 'aeronave', 'data_inf', ' data_sup', 'natureza', 'confirmado','piloto','instrutor','meus_movimentos'];
            <label for="inputAeronave">Aeronave</label>
            <input type="text" name="aeronave" id="inputAeronave" value="{{ $movimento->aeronave}}" placeholder="Aeronave" >
        </div>
       
        <div>
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

    @endsection
