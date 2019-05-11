@extends('master')
@section('content')


  <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">

      <thead>
           <tr>
               <th>Matricula</th>
               <th>Marca</th>
               <th>Modelo</th>
               <th>Numero de lugares</th>
               <th>Contador de horas</th>
               <th>Preço por hora</th>
               @cannot('normal_ativo', Auth::id())
               <th>Criado em</th>
               <th>Atualizado em</th>
               <th>Apagado em </th>
               @endcannot
           </tr>
       </thead>
       @foreach($aeronaves as $aeronave)

           <tr>
               <td>{{$aeronave->matricula}}</td>
               <td>{{$aeronave->marca}}</td>
               <td>{{$aeronave->modelo}}</td>
               <td>{{$aeronave->num_lugares}}</td>
               <td>{{$aeronave->conta_horas}}</td>
               <td>{{$aeronave->preco_hora}}</td>
               @cannot('normal_ativo', Auth::id())
               <td>{{$aeronave->created_at}}</td>
               <td>{{$aeronave->updated_at}}</td>
               <td>{{$aeronave->deleted_at}}</td>
               @endcannot
               @cannot('normal_ativo', Auth::id())
                   <td><a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@edit', $aeronave->matricula) }}">Edit</a></td>

               <td><form action="{{ action('AeronaveController@destroy', $aeronave->matricula) }}"
                     method="post">
                   @csrf
                   @method('delete')
                   <input type="hidden" name="id" value="{{$aeronave->matricula}}">
                   <input  class="btn btn-xs btn-primary" type="submit" value="Delete">
               </form>
               </td>
               @endcannot

               <td><a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@pilotosAutorizados', $aeronave->matricula) }}">Pilotos autorizados</a></td>
               <td><a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@precosTempos', $aeronave->matricula) }}">Ver tempos e precos</a></td>

              </tr>
           @endforeach


          </table>

  <a  class="btn btn-xs btn-primary" href="{{ action('AeronaveController@create') }}">Add Aeronave</a>





@endsection