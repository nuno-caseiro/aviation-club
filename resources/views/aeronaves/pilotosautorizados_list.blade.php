@extends('master')
@section('content')
    <h1>Lista de pilotos autorizados</h1>
    <h2>{{$matricula}}</h2>


        {{--@foreach($pilotosAutorizados as $piloto)
            <li >{{$piloto->piloto_id}}</li>
        @endforeach
    </ul>--}}

<h3>Pilotos Autorizados</h3>



    <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
               <tr>
                @foreach($pilotosAutorizados as $piloto)
                    @foreach($users as $user)
                        @if($user->id== $piloto->piloto_id)

                                <td>{{ $piloto->piloto_id}}</td>
                                <td>{{$user->name}}</td>
                                <td> <a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@addPilotoAutorizado', ['matricula'=>$piloto->matricula, 'piloto' =>$user->id] )}}">Adicionar piloto autorizado</a>
                                </td>
               </tr>
                                </tbody>




                 {{--  <option value={{$piloto->piloto_id}}> {{ $piloto->piloto_id." ".$user->name}} </option>

                    <a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@addPilotoAutorizado', $matricula, $) }}">Adicionar piloto autorizado</a>--}}
                        @endif
                        @endforeach
                @endforeach


    </table>










        <h3>Pilotos Não autorizados</h3>
        <p>
            <select size="15"  style="width: 200px;"  name="addPilotoNaoAutorizado">
                @foreach($pilotosNaoAutorizados as $piloto)
                    <option value=""> {{ $piloto->id." ".$piloto->name}} </option>
                @endforeach    </select>
            </select>


        </p>




@endsection