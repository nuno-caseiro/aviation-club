@extends('master')
@section('content')

<form action="{{action('AeronaveController@store')}}" method="post">
    @csrf
    <div>
        <label for="inputNumSocio">Numero de Sócio</label>
        <input type="text" name="num_socio" id="inputNumSocio" placeholder="NumeroSocio">
    </div>
    <div>
        <label for="inputNome">Nome</label>
        <input type="text" name="name" id="inputNome" placeholder="Nome">
    </div>
    <div>
        <label for="inputNomeInformal">Nome informal/label>
            <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="Nome informal">
    </div>
    <div>
        <label for="inputSexo">Sexo</label>
        <input type="text" name="sexo" id="inputSexo" placeholder="Sexo">
    </div>

    <div>
        <label for="inputEmail">Email</label>
        <input type="email" name="email" id="inputEmail" placeholder="Email">

    </div>
    <div>
        <label for="inputNif">NIF</label>
        <input type="text" name="nif" id="inputNif" placeholder="NIF">
    </div>
    <div>
        <label for="inputDataNascimento">Data Nascimento</label>
        <input type="date" name="data_nascimento" id="inputDataNascimento" placeholder="Data Nascimento">
    </div>
    <div>
        <label for="inputTelefone">Telefone</label>
        <input type="text" name="telefone" id="inputTelefone" placeholder="Telefone">
    </div>
    <div>
        <label for="inputEndereco">Endereço</label>
        <input type="text" name="endereco" id="inputEndereco" placeholder="Endereço">
    </div>

    <div>
            <label for="inputTipoSocio">Tipo de sócio</label>
            <select name="tipo_socio" id="inputTipoSocio" class="form-control">
                    <option disabled selected> -- Escolha uma opção -- </option>
                    <option value="P"  <?= is_selected($user->tipo_socio,'P')?>>Piloto</option>
                    <option value="NP" <?= is_selected($user->tipo_socio,'NP')?>>Não Piloto</option>
                    <option value="A"  <?= is_selected($user->tipo_socio,'A')?>>Aeromodelista</option>
                </select>    
    </div>


    <div>
        <button type="submit" name="ok">Save</button>
    </div>
</form>

@endsection
