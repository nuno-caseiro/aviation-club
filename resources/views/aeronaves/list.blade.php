@extends('master')
@section('content')


   <table class>
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
           @dump($aeronave)
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
           </tr>
           @endforeach


          </table>

    @endsection