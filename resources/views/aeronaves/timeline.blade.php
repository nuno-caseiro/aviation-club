@extends('layouts.app')
@section('content')

    <form method="GET" action="{{action('AeronaveController@timeLine', $matricula)}}">

            <input type="datetime-local" name="data_inf" value="">
            <input type="datetime-local" name="data_sup" value="">




            <button type="submit" class="btn btn-primary">
                {{ __('Aplicar filtro')}}
            </button>
        </form>


<head>
    <meta charset="UTF-8">
    <title>Vertical Timeline component</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


    <link rel="stylesheet" href="{{asset("css/style.css")}}">


</head>





<body>

<section id="status-timeline" class="status-container">
    @foreach($result as $x)
    <div class="status-timeline-block">
        @if($x->tipo_conflito==null)
        <div class="status-timeline-img status-picture">
            <!-- 			<img src="img/status-icon-picture.svg" alt="Picture"> -->
        </div> <!-- status-timeline-img -->
            @else
            <div class="status-timeline-img status-movie">
                <!-- 			<img src="img/status-icon-picture.svg" alt="Picture"> -->
            </div> <!-- status-timeline-img -->
        @endif
        <div class="status-timeline-content">
            <h2>{{$x->aeronave}}</h2>
            <br>
            <h2>Id: <a href="{{ action('MovimentoController@edit', $x->id) }}" >{{$x->id}}</a></h2>
            <br>
            <h2>Piloto id: {{$x->piloto_id}}</h2>

            <span class="status-date">{{$x->data}}</span>
        </div> <!-- status-timeline-content -->
    </div> <!-- status-timeline-block -->
@endforeach

</section> <!-- status-timeline -->



</body>




@endsection