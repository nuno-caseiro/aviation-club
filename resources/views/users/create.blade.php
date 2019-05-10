@extends('master')
@section('content')


<form action="{{action('UserController@store')}}" method="post">
    @csrf
    <div>
        <label for="inputNumSocio">Numero de Sócio</label>
        <input type="text" name="num_socio" id="inputNumSocio" placeholder="Número de Sócio">
    </div>
    <div>
        <label for="inputNome">Nome</label>
        <input type="text" name="name" id="inputNome" placeholder="Nome">
    </div>
    <div>
        <label for="inputNomeInformal">Nome informal</label>
        <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="Nome informal">
    </div>
    <div>
        <label for="inputSexo">Sexo</label>
        <select name="sexo" id="inputSexo">
            <option disabled selected> -- Selecione uma opção -- </option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select>
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
        <label for="inputDataNascimento">Data nascimento</label>
        <input type="date" name="data_nascimento" id="inputDataNascimento">
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
        <label for="inputTipoSocio">Tipo de Sócio </label>
        <select name="tipo_socio" id="inputTipoSocio">
            <option disabled selected> -- Selecione uma opção -- </option>
            <option value="P">Piloto</option>
            <option value="NP">Não Piloto</option>
            <option value="A">Aeromodelista</option>
        </select>
    </div>

    <div>
        <label for="inputQuotaPaga">Quota Paga</label>
        <input type="radio" name="quota_paga" value="1"> Masculino
        <input type="radio" name="quota_paga" value="0"> Feminino
        
    </div>

    <div>
        <label for="inputAtivo">Ativo</label>
        <input type="radio" name="ativo" value="1"> Sim
        <input type="radio" name="ativo" value="1"> Não
    </div>

    <div>
        <label for="inputDirecao">Direção</label>
        <input type="radio" name="direcao" value="1"> Sim
        <input type="radio" name="direcao" value="1"> Não


    </div>
    <div>
        <label for="inputAluno">Aluno</label>
        <input type="text" name="aluno" id="inputAluno" placeholder="Aluno">
    </div>

    <div>
        <label for="inputInstrutor">Instrutor</label>
        <input type="text" name="instrutor" id="inpuInstrutor" placeholder="Instrutor">
    </div>

    <div>
        <label for="inputNrLicenca">Numero da licença</label>
        <input type="text" name="num_licenca" id="inputNrLicenca" placeholder="Número da licença">
    </div>

    <div>
        <label for="inputTipoLicenca">Tipo de licença</label>
       {{--<input type="text" name="tipo_licenca" id="inputTipoLicenca" placeholder="Tipo da licença">--}}
         <select name="classe_certificado">
            @foreach($licencas as $licenca)
                <option value="{{$licenca->code}}">{{$licenca->nome}}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="inputValidadeLicenca">Validade da licença</label>
        <input type="date" name="validade_licenca" id="inputValidadeLicenca">
    </div>

    <div>
        <label for="inputLicencaConfirmada">Licença confirmada</label>
        <input type="radio" name="licenca_confirmada" value="1"> Sim
        <input type="radio" name="licenca_confirmada" value="0"> Não

    </div>

    <div>
        <label for="inputNrCertificado">Número do certificado</label>
        <input type="text" name="num_certificado" id="inputNrCertificado" placeholder="Número do certificado">

    </div>

    <div>
        <label for="inputClasseCertificado">Classe do certificado </label>
      {{--  <input type="text" name="classe_certificado" id="inputClasseCertificado" placeholder="Classe do Certificado">--}}


        <select name="classe_certificado">
            @foreach($classes as $classe)
                <option id="inputClasseCertificado" value="{{$classe->code}}">{{$classe->nome}}</option>
            @endforeach
        </select>


    </div>

    <div>
        <label for="inputValidadeCertificado">Validade d certificado</label>
        <input type="date" name="validade_certificado" id="inputValidadeCertificado">
    </div>

    <div>
        <label for="inputCertificadoConfirmado">Certificado confirmado</label>
        <input type="radio" name="certificado_confirmado" value="1"> Sim
        <input type="radio" name="certificado_confirmado" value="0"> Não

    </div>

    <div>
        <label for="inputFileFoto">Foto sócio </label>
        <input type="file" name="file_foto">
    </div>

    <div>
        <label for="inputFileLicenca">Cópia digital da licença</label>
        <input type="file" name="file_licenca">
    </div>

    <div>
        <label for="inputFileCertificado">Cópia digital do certificado</label>
        <input type="file" name="file_certificado">
    </div>

    <div>
        <button type="submit" name="ok">Save</button>
    </div>
</form>

@endsection
