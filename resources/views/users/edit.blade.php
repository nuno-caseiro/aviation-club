@extends('master')
@section('content')

    <form action="{{action('UserController@update', $user->id)}}" method="post">
        @method('put')
        @csrf

        <div>
            <label for="num_socio">Numero de socio</label>
            <input id="num_socio" type="text"  name="num_socio" value="{{ $user->num_socio }}"  >
            <br>
            <label for="inputName">Nome Completo</label>
            <input type="text" name="name" id="inputName" placeholder="Name"
                   value="{{ $user->name }}">
            <br>
            <label for="inputNomeInformal">Nome Informal</label>
            <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="NomeInformal" value="{{$user->nome_informal}}">    
            <br>

            <label for="inputSexo">Sexo</label>
            <select name="sexo" id="inputSexo" >
                <option value="F" {{ ($user->sexo=="F")? "selected" : "" }}>Feminino</option>
                <option value="M" {{ ($user->sexo=="M")? "selected" : "" }}>Masculino</option>
            </select>

            <div>
                <label for="inputDataNascimento">Data nascimento</label>
                <input type="date" name="data_nascimento" id="inputDataNascimento" value="{{$user->data_nascimento}}">
            </div>

            <div>
                <label for="inputEmail">Email</label>
                <input type="email" name="email" id="inputEmail" placeholder="Email" value="{{$user->email}}">
            </div>

            <div>

                <label for="inputNif">NIF</label>
                <input type="text" name="nif" id="inputNif" placeholder="Nif" value="{{$user->nif}}">
            </div>

            <div>
                <label for="inputTelefone">Telefone</label>
                <input type="text" name="telefone" id="inputTelefone" placeholder="Telefone" value="{{$user->telefone}}">
            </div>

            <div>
                <label for="inputTipoSocio">Tipo de Sócio </label>
                <select name="tipo_socio" id="inputTipoSocio">

                    <option value="P" {{($user->tipo_socio=="P")? "selected" : "" }}>Piloto</option>
                    <option value="NP" {{($user->tipo_socio=="NP")? "selected" : "" }}>Não Piloto</option>
                    <option value="A" {{($user->tipo_socio=="A")? "selected" : "" }}>Aeromodelista</option>
                </select>
            </div>

            <div>
                <label for="inputQuotaPaga">Quota Paga</label>
                <input type="radio" name="quota_paga" value="1" {{ ($user->quota_paga=="1")? "checked" : "" }} > Sim
                <input type="radio" name="quota_paga" value="0" {{ ($user->quota_paga=="0")? "checked" : "" }}> Não

            </div>

            <label for="inputEndereco">Endereço</label>
            <input type="text" name="endereco" id="inputEndereco" placeholder="Endereco" value="{{$user->endereco}}">   
            <br>
            <label for="inputFoto">Foto</label>
            
            <input type="file" name="foto" accept="image/*">
            <br>

          
              
                
        </div>
        <div>
            <button class="btn btn-xs btn-primary" type="submit" name="ok">Save</button>
            <button class="btn btn-xs btn-primary" type="submit" name="cancel">Cancel</button>
        </div>
    </form>

    @endsection