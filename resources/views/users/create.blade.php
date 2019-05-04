@extends('master')
@section('content')

<?php

function is_selected($current, $expected)
{
    return $current === $expected ? 'selected' : '';
}
?>
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

    <div class="form-group">
        <label for="inputType">Type</label>
        <select name="tipo_socio" id="inputType" class="form-control">
            <option disabled selected> -- select an option -- </option>
            <option <?= is_selected(old('tipo_socio', $user->tipo_socio), 'P') ?> value="P">Administrator</option>
            <option <?= is_selected(old('tipo_socio', $user->tipo_socio), 'PN') ?> value="PN">Publisher</option>
            <option <?= is_selected(old('tipo_socio', $user->tipo_socio), 'A') ?> value="A">Client</option>
        </select>
    </div>


    <div>
        <button type="submit" name="ok">Save</button>
    </div>
</form>

@endsection
