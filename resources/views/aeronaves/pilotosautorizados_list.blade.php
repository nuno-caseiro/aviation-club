@extends('master')
@section('content')

    <h1>{{$matricula}}</h1>
    <ul class="list-group">
        @foreach($pilotosAutorizados as $piloto)
            <li class="list-group-item">{{$piloto->piloto_id}}</li>
        @endforeach
    </ul>



@endsection