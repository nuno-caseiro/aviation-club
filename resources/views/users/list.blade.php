@extends('master')
@section('content')


    <h4>Tabela de Utilizadores </h4>



<table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
    <a href="{{ action('UserController@create') }}">Add User</a>



    <form method="GET" action="{{action('UserController@index')}}">

        <legend>Filtrar sócios:</legend>

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
           <select name="tipo" id="inputTipoSocio">
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

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-5">
                <br>
                <button type="submit" class="btn btn-primary">
                    {{ __('Aplicar filtro') }}
                </button>
            </div>
        </div>
        <br>
    </form>

    <thead>
            <tr>
                @cannot('socio_normal',  App\User::class)
                <th>Id</th>
                <th>Nome</th>
                @endcannot
                <th>Email</th>
                    @cannot('socio_normal', App\User::class)
                <th>Email Verificado</th>
                <th>Password</th>
                <th>Remember Token</th>

                <th>Criado em </th>
                <th>Atualizado em</th>
                <th>Apagado em</th>
                    @endcannot
                <th>Numero de sócio</th>
                <th>Nome informal</th>
                    @cannot('socio_normal', App\User::class)
                <th>Sexo</th>
                <th>Data Nascimento</th>
                <th>NIF</th>
                    @endcannot
                <th>Telefone</th>
                @cannot('socio_normal', App\User::class)
                <th>Endereço</th>
                @endcannot
                <th>Tipo sócio</th>
                    @cannot('socio_normal', App\User::class)
                <th>Quota Paga</th>
                <th>Ativo</th>
                <th>Password inicial</th>
                    @endcannot
                <th>Direção</th>
                <th>Foto</th>

                <th>Número de licença</th>

                    @cannot('socio_normal', App\User::class)
                <th>Tipo de licença</th>
                <th>Instrutor</th>
                <th>Aluno</th>
                <th>Validade da licença</th>
                <th>Licença confirmada</th>
                <th>Número de certificado</th>
                <th>Classe do certificado</th>
                <th>Validade do certificado</th>
                <th>Certificado confirmado </th>
                        @endcannot



            </tr>
        </thead>
        @foreach($users as $utilizador)
            <tr>
               {{--<td><img src="{{route('getfile',['user'=>$user->foto_url])}}"></td>--}}
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->id}}</td>
                <td>{{$utilizador->name}}</td>
                @endcannot
                <td>{{$utilizador->email}}</td>
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->email_verified_at}}</td>
                <td>{{$utilizador->password}}</td>
                <td>{{$utilizador->remember_token}}</td>
                <td>{{$utilizador->created_at}}</td>
                <td>{{$utilizador->updated_at}}</td>
                <td>{{$utilizador->deleted_at}}</td>
                @endcannot
                <td>{{$utilizador->num_socio}}</td>
                <td>{{$utilizador->nome_informal}}</td>
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->sexo}}</td>
                <td>{{$utilizador->data_nascimento}}</td>
                <td>{{$utilizador->nif}}</td>
                @endcannot
                <td>{{$utilizador->telefone}}</td>
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->endereco}}</td>
                @endcannot
                <td>{{$utilizador->tipo_socio}}</td>
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->quota_paga}}</td>
                <td>{{$utilizador->ativo}}</td>
                <td>{{$utilizador->password_inicial}}</td>
                @endcannot
                @if($utilizador->direcao==1)
                    <td>Sim</td>
                @else
                    <td>Não</td>
                @endif
                @if($utilizador->foto_url!=null)
                   <td><img src="{{url('storage/app/public/fotos')."/".$utilizador->foto_url}}"></td>
                @else
                    <td></td>
                @endif
                @if($utilizador->tipo_socio=="P")
                    <td>{{$utilizador->num_licenca}}</td>
                @else
                    <td>Não é piloto</td>
                @endif
                @cannot('socio_normal', App\User::class)
                <td>{{$utilizador->tipo_licenca}}</td>
                <td>{{$utilizador->instrutor}}</td>
                <td>{{$utilizador->aluno}}</td>
                <td>{{$utilizador->validade_licenca}}</td>
                <td>{{$utilizador->licenca_confirmada}}</td>
                <td>{{$utilizador->num_certificado}}</td>
                <td>{{$utilizador->classe_certificado}}</td>
                <td>{{$utilizador->validade_certificado}}</td>
                <td>{{$utilizador->certificado_confirmado}}</td>

                <td><a class="btn btn-xs btn-primary" href="{{ action('UserController@edit', $utilizador->id) }}">Edit</a></td>
                <td><form action="{{ action('UserController@destroy', $utilizador->id) }}"
                    method="post">
                  @csrf
                  @method('delete')
                  <input type="hidden" name="id" value="{{$utilizador->id}}">
                  <input class="btn btn-xs btn-primary" type="submit" value="Delete">
              </form>
                @endcannot
               

            </tr>
            @endforeach

   
            
           </table>
           <div class="text-center">

               {!! $users->links(); !!}
    </div>

@endsection
