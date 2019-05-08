@extends('master')
@section('content')
    <h1>Lista de pilotos autorizados</h1>
    <h2>{{$matricula}}</h2>
    <ul class="list-group">

        @foreach($pilotosAutorizados as $piloto)
            <li >{{$piloto->piloto_id}}</li>
        @endforeach
    </ul>



<h3>Pilotos Autorizados</h3>
    <form action="form-action.php" method="post">
        <p>
            <select size="15"  style="width: 200px;" multiple name="pilotosAutorizados[]">
                @foreach($pilotosAutorizados as $piloto)
                    <option value=""> {{ $piloto->piloto_id}}{{$piloto->name}} </option>
                @endforeach    </select>

            </select>
        </p>
        <p>
            <input type="submit" value="Submit me!" />
        </p>
    </form>

 {{--   <h3>Pilotos Não autorizados</h3>
    <form action="form-action.php" method="post">
        <p>
            <select size="15"  style="width: 200px;" multiple name="pilotosNaoAutorizados[]">
                @foreach($pilotosNaoAutorizados as $piloto)
                    <option value=""> {{ $piloto->piloto_id}} </option>
                @endforeach    </select>

            </select>
        </p>
        <p>
            <input type="submit" value="Submit me!" />
        </p>
    </form>
--}}

@endsection