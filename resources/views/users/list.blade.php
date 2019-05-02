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
              
               

            </tr>
            @endforeach

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src=" https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">

        $(document).ready(function(){
            $('#mydatatable').DataTable();
        });

    </script>
            
           </table>
           

@endsection
