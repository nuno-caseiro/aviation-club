@extends('layouts.app')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif
    
<script type="text/javascript">
     function preco_hora_label() {
        var inputMinuto=document.getElementById("inputMinuto[10]").value;
           var inputPreco=document.getElementById("inputPreco[10]").value;
       
        if(inputMinuto!="" && inputPreco!=""){    
     document.getElementById("inputPrecoHora").value=inputPreco;
        }

     }



</script>






        



















    <form method="POST" action="{{action('AeronaveController@store')}}" >
        @method("POST")
        @csrf
        <div>
            <label for="inputMatricula">Matricula</label>
            <input type="text" name="matricula" id="inputMatricula"  placeholder="Matricula" >
        </div>
        <div>
            <label for="inputMarca">Marca</label>
            <input type="text" name="marca" id="inputMarca"  placeholder="Marca" >
        </div>
        <div>
            <label for="inputModelo">Modelo</label>
            <input type="text" name="modelo" id="inputModelo"  placeholder="Modelo" >
        </div>
        <div>
            <label for="inputNrLugares">Numero de lugares</label>
            <input type="text" name="num_lugares" id="inputNrLugares"  placeholder="Numerolugares" >
        </div>

        <div>
            <label for="inputContaHoras">Conta horas</label>
            <input type="text" name="conta_horas" id="inputContaHoras" placeholder="Conta horas" >
        </div>
        <div>
            <label for="inputPrecoHora">Preco hora</label>
            <input type="text" name="preco_hora" id="inputPrecoHora"  placeholder="Preco hora"  readonly>
        </div>

        <div>
            <button type="submit" name="ok">Save</button>
        </div>

        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>Unidade conta horas</th>
                    <th>Minutos</th>
                    <th>Preco</th>
                </tr>
                </thead>

                <tbody>
                @for($i=1; $i<=10; $i++)
                    <tr>
                        <th>{{$i}}</th>
                        <th> <input type="text" name="tempos[{{$i}}]" id="inputMinuto[{{$i}}]" value="" placeholder="" onchange="preco_hora_label()" >    </th>
                        <th> <input type="text" name="precos[{{$i}}]" id="inputPreco[{{$i}}]" value="" placeholder="" onchange="preco_hora_label()" >    </th>

                    </tr>

                @endfor

                </tbody>
            </table>

        </div>
    </form>

@endsection
