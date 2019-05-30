@extends('layouts.app')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif
    <h4>Tabela de Utilizadores </h4>







    <form method="GET" action="{{action('UserController@index')}}">

        <legend>Filtrar sócios</legend>
        <div>
            Número sócio:
            <input id="num_socio" type="text" class="form-control{{ $errors->has('num_socio') ? ' is-invalid' : '' }}" name="num_socio" value="{{ old('num_socio') }}"  autofocus>
        </div>
      <div>
          Nome informal:
          <input id="nome_informal" type="text" class="form-control{{ $errors->has('nome_informal') ? ' is-invalid' : '' }}" name="nome_informal" value="{{ old('nome_informal') }}"  autofocus>
      </div>
       <div>
           E-mail:
           <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  autofocus>
       </div>

       <div>
           Tipo de Sócio :
           <select  id="inputTipoSocio" name="tipo" >
               <option  value=""></option>
               <option  value="P">Piloto</option>
               <option  value="NP">Não Piloto</option>
               <option  value="A" >Aeromodelista</option>
           </select>
       </div>

        <div>
            Direção:
            <input id="direcao" type="text" class="form-control{{ $errors->has('direcao') ? ' is-invalid' : '' }}" name="direcao" value="" >
        </div>

        @can('socio_Direcao', App\User::class)
            <div>Quotas em dia:
                <input id="quotas_pagas" type="text" class="form-control{{ $errors->has('quotas_pagas') ? ' is-invalid' : '' }}" name="quotas_pagas" value="{{ old('quotas_pagas') }}" >
            </div>
            <div>
            Sócio ativo:
                <input id="ativo" type="text" class="form-control{{ $errors->has('ativo') ? ' is-invalid' : '' }}" name="ativo" value="{{ old('ativo') }}" >
            </div>
        @endcan

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-5">

                <br>
                <button type="submit" class="btn btn-primary">
                    {{ __('Aplicar filtro')}}
                </button>

            </div>

        </div>
        <br>

    </form>

    <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
        <a class="btn btn-xs btn-primary" href="{{ action('UserController@create') }}">Add User</a>


    <thead>
    <tr>

        <th>Foto</th>
        <th>Numero de sócio</th>
        <th>Nome informal</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Tipo sócio</th>
        <th>Número de licença</th>
        <th>Direção</th>
        @can('socio_Direcao', App\User::class)
            <th>Quotas pagas</th>
            <th>Sócio Ativo</th>
        @endcan
        @can('socio_Direcao', Auth::User())
        <th>

                <div>
                        <form method="POST" action="{{action('UserController@resetQuotas')}}">
                            @csrf
                            <input type="hidden" name="_method" value="patch">

                            <input class="btn btn-xs btn-primary" type="submit" value="Reset quotas">

                        </form>
                </div>

        </th>
            <th>
                <div>
                    <form method="POST" action="{{action('UserController@resetAtivosSemQuota')}}">
                        @csrf
                        <input type="hidden" name="_method" value="patch">

                        <input class="btn btn-xs btn-primary" type="submit" value="Reset ativos QPP">

                    </form>
                </div>


            </th>
        @endcan
    </tr>
    </thead>
<tbody>

        @foreach($users as $utilizador)
            <tr>
                @if($utilizador->foto_url!=null)
                    <td><img src="{{Storage::url('public/fotos'.'/'.$utilizador->foto_url)}}"></td>
                @else
                    <td></td>
                @endif
                    <td>{{$utilizador->num_socio}}</td>
                    <td>{{$utilizador->nome_informal}}</td>
                    <td>{{$utilizador->email}}</td>
                    <td>{{$utilizador->telefone}}</td>
                    <td>{{$utilizador->tipo_socio}}</td>
                    @if($utilizador->tipo_socio=="P")
                        <td>{{$utilizador->num_licenca}}</td>
                    @else
                        <td>Não é piloto</td>
                    @endif
                    @if($utilizador->direcao==1)
                        <td>Sim</td>
                    @else
                        <td>Não</td>
                    @endif

                    @can('socio_Direcao', App\User::class)
                        <td> <form method="POST" action="{{action('UserController@quotaPaga', $utilizador->id)}}">
                                @csrf
                                <input type="hidden" name="_method" value="patch">
                                <input type="hidden" name="quota_paga" value="{{!$utilizador->quota_paga}}">
                                @if($utilizador->quota_paga==1)
                                    <input class="btn btn-xs btn-primary" type="submit" value="Paga">
                                @else
                                    <input class="btn btn-xs btn-primary" type="submit" value="Por pagar">
                                @endif
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{action('UserController@ativarDesativar', $utilizador->id)}}">
                                @csrf
                                <input type="hidden" name="_method" value="patch">
                                <input type="hidden" name="ativo" value="{{!$utilizador->ativo}}">
                            @if($utilizador->ativo==1)
                                    <input class="btn btn-xs btn-primary" type="submit" value="Desativar">
                            @else
                                <input class="btn btn-xs btn-primary" type="submit" value="Ativar">
                            @endif
                        </form>
                        </td>
                    @endcan



                <td><a class="btn btn-xs btn-primary" href="{{ action('UserController@edit', $utilizador->id) }}">Editar</a></td>

                <td>
                    <form action="{{ action('UserController@destroy', $utilizador->id) }}"
                    method="post">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" value="{{$utilizador->id}}">
                  <input class="btn btn-xs btn-primary" type="submit" value="Delete">
                    </form>
                </td>

               

            </tr>
            @endforeach


</tbody>
</table>
           <div class="text-center">

               {!! $users->links(); !!}
            </div>

@endsection
