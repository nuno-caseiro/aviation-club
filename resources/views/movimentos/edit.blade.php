@extends('master')
@section('content')

    <form action="{{--action('AeronaveController@update', $aeronave->matricula)--}}" method="post">
        @method('put')
        @csrf
        <div>
            <label for="inputMatricula">Matricula</label>
            <input type="text" name="matricula" id="inputMatricula" placeholder="Matricula"
                   value="{{ $aeronave->matricula }}">
        </div>
        <div>
            <button type="submit" name="ok">Save</button>
            <button type="submit" name="cancel">Cancel</button>
        </div>
    </form>

    @endsection
