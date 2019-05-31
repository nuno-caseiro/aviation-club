@extends('layouts.app')
@section('content')


        <!DOCTYPE html>
<html lang="en" >

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
        <div class="status-timeline-img status-picture">
            <!-- 			<img src="img/status-icon-picture.svg" alt="Picture"> -->
        </div> <!-- status-timeline-img -->

        <div class="status-timeline-content">
            <h2>{{$x->aeronave}}</h2>

            <h3> <a href="{{ action('UserController@edit', $x->id) }}" >{{$x->id}}</a></h3>

            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>

            <span class="status-date">{{$x->data}}</span>
        </div> <!-- status-timeline-content -->
    </div> <!-- status-timeline-block -->
@endforeach

</section> <!-- status-timeline -->



</body>

</html>


@endsection