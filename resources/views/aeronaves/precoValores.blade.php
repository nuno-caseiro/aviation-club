@extends('layouts.app')
@section('content')

    <h1>{{$title}}</h1>
    <h2>{{$matricula}}</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Unidade conta horas</th>
            <th>Minutos</th>
            <th>Preco</th>
        </tr>
        </thead>

        <tbody>
        @foreach(json_decode($aeronaveValores, true) as $value)
            <tr>
                <th>{{$value['unidade_conta_horas']}}</th>
                <th> {{$value['minutos']}}     </th>
                <th> {{$value['preco']}}    </th>
            </tr>
        @endforeach

        </tbody>
    </table>

     @endsection