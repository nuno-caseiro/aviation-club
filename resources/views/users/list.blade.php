@extends('master')
@section('content')


    <h4>Tabela de Utilizadores </h4>



<table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
    <a href="{{ action('UserController@create') }}">Add User</a>  
    <thead>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Email Verificado</th>
                <th>Password</th>
                <th>Remember Token</th>
                <th>Criado em </th>
                <th>Atualizado em</th>
                <th>Apagado em</th>
                <th>Numero de sócio</th>
                <th>Nome informal</th>
                <th>Sexo</th>
                <th>Data Nascimento</th>
                <th>NIF</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Tipo sócio</th>
                <th>Quota Paga</th>
                <th>Ativo</th>
                <th>Password inicial</th>
                <th>Direção</th>
                <th>Foto</th>
                <th>Número de licença</th>
                <th>Tipo de licença</th>
                <th>Instrutor</th>
                <th>Aluno</th>
                <th>Validade da licença</th>
                <th>Licença confirmada</th>
                <th>Número de certificado</th>
                <th>Classe do certificado</th>
                <th>Validade do certificado</th>
                <th>Certificado confirmado </th>



            </tr>
        </thead>
        @foreach($users as $utilizador)
            <tr>
                <td>{{$utilizador->id}}</td>
                <td>{{$utilizador->name}}</td>
                <td>{{$utilizador->email}}</td>
                <td>{{$utilizador->email_verified_at}}</td>
                <td>{{$utilizador->password}}</td>
                <td>{{$utilizador->remember_token}}</td>
                <td>{{$utilizador->created_at}}</td>
                <td>{{$utilizador->updated_at}}</td>
                <td>{{$utilizador->deleted_at}}</td>
                <td>{{$utilizador->num_socio}}</td>
                <td>{{$utilizador->nome_informal}}</td>
                <td>{{$utilizador->sexo}}</td>
                <td>{{$utilizador->data_nascimento}}</td>
                <td>{{$utilizador->nif}}</td>
                <td>{{$utilizador->telefone}}</td>
                <td>{{$utilizador->endereco}}</td>
                <td>{{$utilizador->tipo_socio}}</td>
                <td>{{$utilizador->quota_paga}}</td>
                <td>{{$utilizador->ativo}}</td>
                <td>{{$utilizador->password_inicial}}</td>
                <td>{{$utilizador->direcao}}</td>
                <td>{{$utilizador->foto_url}}</td>
                <td>{{$utilizador->num_licenca}}</td>
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
                  <input type="submit" value="Delete">
              </form>
              
               

            </tr>
            @endforeach

   
            
           </table>
           <div class="text-center">
      {!! $users->links(); !!}

    </div>

@endsection
