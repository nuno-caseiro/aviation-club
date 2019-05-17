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
                               <td><form action="{{ action('AeronaveController@removePilotoAutorizado', ['matricula'=>$piloto->matricula, 'piloto' =>$user->id] ) }}"
                                         method="post">
                                       @csrf
                                       @method('delete')
                                       <input class="btn btn-xs btn-primary" type="submit" value="Remover piloto autorizado">
                                   </form>
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


    <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            @foreach($pilotosNaoAutorizados as $piloto)
                @foreach($users as $user)
                    @if($user->id== $piloto->id)

                        <td>{{ $piloto->id}}</td>
                        <td>{{$user->name}}</td>
                        {{--<td> <a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@addPilotoAutorizado', ['matricula'=>$piloto->matricula, 'piloto' =>$user->id] )}}">Adicionar piloto autorizado</a>
                        </td>--}}
                        <td><form action="{{ action('AeronaveController@addPilotoAutorizado', ['matricula'=>$matricula, 'piloto' =>$user->id] ) }}"
                                  method="post">
                                @csrf
                                @method('post')
                                <input class="btn btn-xs btn-primary" type="submit" value="Adicionar piloto autorizado">
                            </form>
                        </td>



        </tr>
        </tbody>




        {{--  <option value={{$piloto->piloto_id}}> {{ $piloto->piloto_id." ".$user->name}} </option>

           <a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@addPilotoAutorizado', $matricula, $) }}">Adicionar piloto autorizado</a>--}}
        @endif
        @endforeach
        @endforeach


    </table>






@endsection