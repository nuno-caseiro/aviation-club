@extends('master')
@section('content')

    <form action="{{action('MovimentoController@update', $movimento->id)}}" method="post" >
        @method('put')
        @csrf


        <div class="card-header">Editar Movimento</div>
        <div>
            <label >Aeronave</label>
            <select name="members">
                @foreach ($aeronaves as $aeronave)
                    <option value="{{ $aeronave->matricula }}" {{ ( $aeronave->matricula == $movimento->aeronave) ? 'selected' : $movimento->aeronave }}> {{ $aeronave->matricula }} </option>
                @endforeach    </select>

            <br>
            <label>Natureza</label>
            <select name="natureza">
                <option value="{{ $movimento->natureza}}">@if ($movimento->natureza=='I')
                        Instruçao
                    @endif
                    @if ($movimento->natureza=='T')
                        Treino
                    @endif
                    @if ($movimento->natureza=='E')
                        Especial
                    @endif
                </option>

                @if ($movimento->natureza!='I')
                    <option value="I">Instruçao</option>

                @endif

                @if ($movimento->natureza!='T')
                    <option value="T">Treino</option>
                @endif

                @if ($movimento->natureza!='E')
                    <option value="E">Especial</option>
                @endif

            </select>
            <div>
                <label for="input">Estado</label>
                <select name=confirmado>
                    <option value="{{ $movimento->confirmado}}">@if ($movimento->confirmado==1)
                            Confirmado
                        @endif
                        @if ($movimento->confirmado==0)
                            Por Confirmar
                        @endif
                    </option>
                    Alterara para ser um botao para confirmar mais tarde
                    @if ($movimento->confirmado==1)
                        <option value=0>Por Confirmar</option>
                    @endif
                    @if ($movimento->confirmado==0)
                        <option value=1>Confirmado</option>
                    @endif
                </select>
            </div>

            <label >Socios</label>
            <select name="piloto_id"   onchange="location.reload()">
                @foreach ($socios as $socio)
                    <option value="{{$socio->id}}" {{(  $socio->id == $movimento->piloto_id) ? 'selected' : $movimento->piloto_id }}> {{ $socio->id }}
                    </option>

                    @if ($socio->id==$movimento->piloto_id)
                        <label>{{$socio->name}}</label>
                    @endif
                @endforeach    </select>


            <div></div>

            @if ($movimento->instrutor_id!=NULL)
                <label >Instrutor</label>
                <select name="instrutor_id">
                    @foreach ($socios as $socio)
                        @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                            <option value="{{$movimento->instrutor_id}}" {{($socio->id == $movimento->instrutor_id) ? 'selected' : $movimento->instrutor_id }}> {{ $socio->id }} </option>
                        @endif
                    @endforeach    </select>

            @endif




        </div>

        <div>
            <button type="submit" name="ok">Save</button>

        </div>
    </form>

@endsection
