@extends('master')
@section('content')
    <h1>Lista de pilotos autorizados</h1>
    <h2>{{$matricula}}</h2>


        {{--@foreach($pilotosAutorizados as $piloto)
            <li >{{$piloto->piloto_id}}</li>
        @endforeach
    </ul>--}}

<h3>Pilotos Autorizados</h3>

        <p>
            <select size="15"  style="width: 200px;" name="removePilotoAutorizado">
                @foreach($pilotosAutorizados as $piloto)
                    <option value=""> {{ $piloto->piloto_id}}{{$piloto->name}} </option>
                @endforeach    </select>

            </select>
        </p>
      {{--<a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@addPilotoAutorizado', $matricula) }}">Adicionar piloto autorizado</a>


        <h3>Pilotos Não autorizados</h3>
        <p>
            <select size="15"  style="width: 200px;"  name="addPilotoNaoAutorizado">
                @for($i=0; $i<=count($pilotosNaoAutorizados)-1; $i++)
                    {{$i=0}}
                    @dump($pilotosNaoAutorizados);
                    <option value=""> {{ $pilotosNaoAutorizados[0]['id']}} </option>
                @endfor
            </select>


        </p>

    --}}


@endsection