@extends('layouts.app')
@section('content')


    {{--<script type="text/javascript">
        function checkAndUncheck(){
            var allRadios = document.getElementsByName('confirmado');
            var booRadio;
            var x = 0;
            for(x = 0; x < allRadios.length; x++){
                allRadios[x].onclick = function() {
                    if(booRadio == this){
                        this.checked = false;
                        booRadio = null;
                    } else {
                        booRadio = this;
                    }
                };
            }
        }
    </script>
    --}}




        <legend>Filtrar Movimentos:</legend>
        <form method="GET" action="{{action('MovimentoController@index')}}">


            <div> <label>Movimento ID:</label>
            <input type="number"  name="id"> </div>

            <label>Aeronaves</label>
            <select name="aeronave">
                <option></option>
                @foreach ($aeronaves as $aeronave)
                    <option value="{{ $aeronave->matricula }}" @if (!is_null($data['aeronave']) && $data['aeronave']==$aeronave->matricula)
                    selected="selected"
                            @endif > {{ $aeronave->matricula }} </option>
                @endforeach    </select>


            <div>
                <label>Natureza</label>
                <select name="natureza" id="natureza">
                    <option  value=""></option>
                    <option  value="I" >Instrucao</option>
                    <option  value="T">Treino</option>
                    <option  value="E"> Especial</option>
                </select>
            </div>


            <div>
            <label>Cofirmado:</label>
            <input  type="radio" id="confirmado" name="confirmado" value="1"><label for="confirmado" class="light">Confirmado</label>
            <input type="radio" name="confirmado" value="0"><label for="Confirmar" class="light">Por Confirmar</label>
            </div>

<div>
    <label >Socios</label>
    <select name="piloto">
        <option></option>
        @foreach ($users as $socio)
            <option value="{{$socio->id}}" @if (!is_null($data['piloto']) && $data['piloto']==$socio->id)
            selected="selected"
                    @endif> {{ $socio->id }}
            </option>
        @endforeach
    </select>
</div>
            @if(Auth::user()->can('socio_DP', Auth::user()))
            <div>
                <label for="meus_movimentos">Meus movimentos: </label>
                <input name="meus_movimentos" value="{{Auth::id()}}" type="checkbox" id="meus_movimentos">
            </div>
            @endif



            <label >Instrutor</label>
            <select name="instrutor">
                <option></option>
                @foreach ($users as $socio)
                    @if ($socio->tipo_socio=='P' && $socio->instrutor==1)
                        <option value="{{$socio->id}}" @if (!is_null($data['instrutor']) && $data['instrutor']==$socio->id)
                        selected="selected"
                                @endif> {{ $socio->id }}</option>
                    @endif
                @endforeach

            </select>

            <label>Hora:</label>
            <input type="datetime-local" name="data_inf" value="">
            <input type="datetime-local" name="data_sup" value="">


            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-5">
                    <br>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Aplicar filtro') }}
                    </button>
                </div>
            </div>



{{--
            @if(Auth::user()->can('socio_DP', Auth::user()))
                @if(is_null($pressed) || $pressed=='false' )
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <br>

                            <button type="submit" class="btn btn-primary" name = "movimentos" value = "true">Meus Movimentos</button>
                        </div>
                    </div>

                @endif
                @if($pressed=='true')
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-5">
                            <br>

                            <button type="submit" class="btn btn-primary" name = "movimentos" value = "false">Todos Movimentos</button>
                        </div>
                    </div>

                @endif
            @endif
--}}



            @if(Auth::user()->can('socio_Direcao', Auth::user()))




                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-5">
                        <br>
                        <button  name="confirmarVarios" value="true" type="submit" class="btn btn-primary">
                            {{ __('Confirmar Varios') }}
                        </button>
                    </div>
                </div>

            @endif



<table class="table table-striped table-bordered" style="width: 100%">
        <thead>
        <tr >

            <th>ID</th>
            <th>Data</th>
            <th>Hora Descolagem</th>
            <th>Hora Aterragem</th>
            @cannot('normal_ativo', Auth::id())
                <th>Aeronave</th>
            @endcannot
            @cannot('normal_ativo', Auth::id())
                <th>Piloto </th>
            @endcannot
            <th>Natureza</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Numero Pessoas</th>
            <th>Conta Horas Inicio</th>
            <th>Conta Horas Fim</th>
            <th>Tempo de Voo</th>
            <th>Preço Voo</th>
            <th>Confirmado</th>
            <th>Tipo Instrucao</th>
            <th>Instrutor</th>
            <th>Numero Aterragens</th>
            <th>Numero Descolagens</th>
            <th>Numero Servico</th>
            <th>Numero Diario</th>
            @cannot('socio_normal', Auth::user())
            <th>Tipo Conflito</th>
            <th>Razao Conflito</th>
                @endcannot
        </tr>
        </thead>

        <tbody>
        @foreach($movimentos as $movimento)
            <tr @if ($movimento->tipo_conflito=='B')  class="table-warning"     @endif      @if($movimento->tipo_conflito=='S') class="table-danger"   @endif>
                <td>{{$movimento->id}}</td>
                <td>{{$movimento->data}}</td>
                <td>{{$movimento->hora_descolagem}}</td>
                <td>{{$movimento->hora_aterragem}}</td>

                    <td>{{$movimento->aeronave}}</td>

                @foreach($users as $user)
                    @if($movimento->piloto_id== $user->id)
                        <td>{{$user->nome_informal}}</td>
                    @endif
                @endforeach


                    @if ($movimento->natureza=='E')   <td>Especial</td> @endif
                    @if ($movimento->natureza=='T')     <td>Treino</td> @endif
                    @if ($movimento->natureza=='I')  <td>Instrução</td> @endif



                @foreach($aerodromos as $aerodromo)
                    @if ($movimento->aerodromo_partida == $aerodromo->code)
                        <td> {{$aerodromo->code}}</td>
                    @endif
                    @if ($movimento->aerodromo_chegada == $aerodromo->code)
                        <td>{{$aerodromo->code}}</td>
                    @endif
                @endforeach

                <td>{{$movimento->num_pessoas}}</td>
                <td>{{$movimento->conta_horas_inicio}}</td>
                <td>{{$movimento->conta_horas_fim}}</td>

                    <td>{{$movimento->tempo_voo}}</td>
                    <td>{{$movimento->preco_voo}}</td>



                @if($movimento->confirmado=='1')
                    <td> Confirmado</td>
                @else
                    <td>Por Confirmar</td>
                @endif


                @if ($movimento->tipo_instrucao=='D')  <td>Duplo</td> @endif
                @if ($movimento->tipo_instrucao=='S')  <td>Simples</td> @endif
                @if (is_null($movimento->tipo_instrucao))  <td>-</td> @endif


                @if (is_null($movimento->instrutor_id))  <td>-</td> @endif
                @foreach($users as $user)
                    @if($movimento->instrutor_id== $user->id  )
                        <td>{{$user->nome_informal}}</td>
                    @endif

                @endforeach


                <td>{{$movimento->num_aterragens}}</td>
                <td>{{$movimento->num_descolagens}}</td>
                <td>{{$movimento->num_servico}}</td>
                <td>{{$movimento->num_diario}}</td>
                @cannot('socio_normal', Auth::user())
                <td>@if($movimento->tipo_conflito!=null)
                  {{$movimento->tipo_conflito}}
                  @else
                  -
                  @endif
                </td>
              <td>
                      {{$movimento->justificacao_conflito}}
              </td>
            @endcannot

                    @if(Auth::user()->can('socio_Direcao', Auth::user()))
                        @if($movimento->confirmado==1)
                            <td> <input type="checkbox"  checked="true" onclick="return false;" value={{$movimento->id}}>Confirmar</td>
                        @else
                            <td> <input type="checkbox" name="checkboxConfirmado[]" value="{{$movimento->id}}"><label>Confirmado</label></td>
                        @endif
                    @endif


                </form>




                @if($movimento->confirmado=='1' )
                    @if(Auth::user()->can('socio_Direcao', Auth::user()) || auth()->user()->id==$movimento->piloto_id || auth()->user()->id==$movimento->instrutor)
                    <td><a class="btn btn-xs btn-primary" disabled >Edit</a></td>
                    <td>
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" >
                        <input type="submit" value="Delete" disabled>
                    </td>
                    @endif

                @else
                
                   <form action="{{ action('MovimentoController@destroy', $movimento->id) }}"
                    method="post">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" value="{{$movimento->id}}">
                  <input class="btn btn-xs btn-primary" onclick="return confirm('Tem a certeza que deseja eleminar o movimento '{{$movimento->id}})" type="submit" value="Delete">
                    </form>

                    @endif



        @endforeach

        </tbody>
    </table>



                    @if(Auth::user()->can('socio_Direcao', Auth::user())  ||  Auth::user()->can('socio_Piloto', Auth::user()))
    <a href="{{ action('MovimentoController@create') }}"class="btn btn-primary">Adicionar Movimento</a>

    @endif



   {!! $movimentos->links(); !!}



@endsection
