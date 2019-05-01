@extends('master')
@section('content')


  <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
      <a href="{{ action('AeronaveController@create') }}">Add User</a>

      <thead>
           <tr>
               <th>Matricula</th>
               <th>Marca</th>
               <th>Modelo</th>
               <th>Numero de lugares</th>
               <th>Contador de horas</th>
               <th>Preço por hora</th>
               <th>Criado em</th>
               <th>Atualizado em</th>
               <th>Apagado em</th>
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
               <td>{{$aeronave->created_at}}</td>
               <td>{{$aeronave->updated_at}}</td>
               <td>{{$aeronave->deleted_at}}</td>
               <td><a class="btn btn-xs btn-primary" href="{{ action('AeronaveController@edit', $aeronave->matricula) }}">Edit</a></td>
               <td><form action="{{ action('AeronaveController@destroy', $aeronave->matricula) }}"
                     method="post">
                   @csrf
                   @method('delete')
                   <input type="hidden" name="id" value="{{$aeronave->matricula}}">
                   <input type="submit" value="Delete">
               </form>
               </td>
              </tr>
           @endforeach


          </table>


          



    @endsection