@extends('master')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif

  {{--  <script>
        function myFunction() {
            var selectedValue=document.getElementById("inputTipoSocio").value;

            if(selectedValue != "P") {
                document.getElementById("inputNrLicenca").style="display: none;"
                document.getElementById("labelInputNrLicensa").style="display: none;"
                document.getElementById("labeValidadeLicenca").style="display: none;"
                document.getElementById("validade_licenca").style="display: none;"
                document.getElementById("labelInputTipoLicensa").style="display: none;"
                document.getElementById("inputTipoLicenca").style="display: none;"
                document.getElementById("labelinputInstrutor").style="display: none;"
                document.getElementById("inputInstrutor").style="display: none;"
                document.getElementById("labeValidadeLicenca").style="display: none;"
                document.getElementById("validade_licenca").style="display: none;"
                document.getElementById("labelInoutLicencaConfirmada").style="display: none;"
                document.getElementById("inputLicencaConfirmada1").style="display: none;"
                document.getElementById("inputLicencaConfirmada2").style="display: none;"
                document.getElementById("labelLicencaConf").style="display: none;"
                document.getElementById("labelLicencaNaoConf").style="display: none;"
                document.getElementById("labelCopia").style="display: none;"
                document.getElementById("hrefDownload").style="display: none;"
                document.getElementById("classe_certificado").style="display: none;"
                document.getElementById("labelCertificado").style="display: none;"
                document.getElementById("inputNrCertificado").style="display: none;"
                document.getElementById("labelNrCerificado").style="display: none;"
                document.getElementById("validade_certificado").style="display: none;"
                document.getElementById("inputValidadeCertificado").style="display: none;"
                document.getElementById("inputCertificadoPorConfirmar").style="display: none;"
                document.getElementById("naoConfirmado").style="display: none;"
                document.getElementById("inputCertificadoConfirmado").style="display: none;"
                document.getElementById("confirmado").style="display: none;"
                document.getElementById("labelCertificadoConfirmado").style="display: none;"
                document.getElementById("labelCopiaDigital").style="display: none;"
//Antonio Tens de meter tudo com Inputs a null aqui ou metes no controller a null baseado no tipoSocio
                document.getElementById("inputCertificadoConfirmado").value=null;
                document.getElementById("inputNrLicenca").value=null;
                document.getElementById("inputTipoLicenca").value=null;
                document.getElementById("inputInstrutor").value=null;
                document.getElementById("inputLicencaConfirmada1").value=null;
                document.getElementById("inputLicencaConfirmada2").value=null;
                document.getElementById("inputNrCertificado").value=null;
                document.getElementById("inputValidadeCertificado").value=null;
                document.getElementById("inputCertificadoPorConfirmar").value=null;
                document.getElementById("inputCertificadoConfirmado").value=null;



            }else{
                document.getElementById("inputNrLicenca").style="display: ?;"
                document.getElementById("labelInputNrLicensa").style="display: ?;"
                document.getElementById("labeValidadeLicenca").style="display: ?;"
                document.getElementById("validade_licenca").style="display: ?;"
                document.getElementById("labelInputTipoLicensa").style="display: ?;"
                document.getElementById("inputTipoLicenca").style="display: ?;"
                document.getElementById("labelinputInstrutor").style="display: ?;"
                document.getElementById("inputInstrutor").style="display: ?;"
                document.getElementById("labeValidadeLicenca").style="display: ?;"
                document.getElementById("validade_licenca").style="display: ?;"
                document.getElementById("labelInoutLicencaConfirmada").style="display: ?;"
                document.getElementById("inputLicencaConfirmada1").style="display: ?;"
                document.getElementById("inputLicencaConfirmada2").style="display: ?;"
                document.getElementById("labelLicencaConf").style="display: ?;"
                document.getElementById("labelLicencaNaoConf").style="display: ?;"
                document.getElementById("labelCopia").style="display: ?;"
                document.getElementById("hrefDownload").style="display: ?;"
                document.getElementById("classe_certificado").style="display: ?;"
                document.getElementById("labelCertificado").style="display: ?;"
                document.getElementById("inputNrCertificado").style="display: ?;"
                document.getElementById("labelNrCerificado").style="display: ?;"
                document.getElementById("validade_certificado").style="display: ?;"
                document.getElementById("inputValidadeCertificado").style="display: ?;"
                document.getElementById("inputCertificadoPorConfirmar").style="display: ?;"
                document.getElementById("naoConfirmado").style="display: ?;"
                document.getElementById("inputCertificadoConfirmado").style="display: ?;"
                document.getElementById("confirmado").style="display: ?;"
                document.getElementById("labelCertificadoConfirmado").style="display: ?;"
                document.getElementById("labelCopiaDigital").style="display: ?;"

            }
        }
    </script>

--}}




    <form method="POST" action="{{route('socios.update', $user->id)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <input type="hidden" value="{{$user->id}}" name="id">


        <div>
            <label for="num_socio">Número de socio</label>
            <input id="num_socio" type="text" name="num_socio" value="{{ $user->num_socio }}" >
        </div>

        <div>
            <label for="inputName">Nome Completo</label>
            <input type="text" name="name" id="inputName" placeholder="Name" value="{{ $user->name }}">
        </div>

        <div>
            <label for="inputNomeInformal">Nome Informal</label>
            <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="NomeInformal" value="{{$user->nome_informal}}">
        </div>
        <div>
            <label for="inputSexo">Sexo</label>
            <select name="sexo" id="inputSexo" >
                <option value="F" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->sexo=="F")? "selected" : "disabled" }} @endif
                          >Feminino</option>
                <option value="M" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->sexo=="M")? "selected" : "disabled" }} @endif
                        >Masculino</option>
            </select>
        </div>


        <div>
            <label >Data nascimento</label>
            <input type="date" name="data_nascimento" format="YYYY-MM-DD" value="{{$user->data_nascimento}}">
        </div>

        <div>
            <label for="inputEmail">Email</label>
            <input type="email" name="email" id="inputEmail" placeholder="Email" value="{{old('email', $user->email)}}">
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
                <option value="P" @if((Auth::user()->can('socio_normal',App\User::class))) {{($user->tipo_socio=="P")? "selected" : "disabled" }} @endif >Piloto</option>
                <option value="NP"@if((Auth::user()->can('socio_normal',App\User::class))) {{($user->tipo_socio=="NP")? "selected" : "disabled" }} @endif >Não Piloto</option>
                <option value="A" @if((Auth::user()->can('socio_normal',App\User::class))) {{($user->tipo_socio=="A")? "selected" : "disabled" }} @endif>Aeromodelista</option>
            </select>
        </div>

        <div>
            <label for="inputQuotaPaga"  >Quotas em dia</label>
            <input type="radio" name="quota_paga" value="1" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->quota_paga=="1")? "checked" : "disabled" }} @else
                {{ ($user->quota_paga=="1")? "checked" : "" }}
                    @endif  > Sim
            <input type="radio" name="quota_paga" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->quota_paga=="0")? "checked" : "disabled" }} @else
                {{ ($user->quota_paga=="0")? "checked" : "" }}
                    @endif> Não
        </div>
        {{--    @can('socio_Direcao', Auth::User())
    <div>

                <form method="POST" action="{{action('UserController@quotaPaga', $user->id)}}">
                    @csrf

                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="quota_paga" value="{{$user->quota_paga}}">
                    @if($user->quota_paga==1)
                        <input class="btn btn-xs btn-primary" type="submit" value="Paga">
                    @else
                        <input class="btn btn-xs btn-primary" type="submit" value="Por pagar">
                    @endif
                </form>

            </div>
            @endcan
--}}
        <div>
            <label for="inputEndereco">Endereço</label>
            <textarea type="text" name="endereco" id="inputEndereco">{{$user->endereco}} </textarea>
        </div>

        <div>
            <label for="inputAtivo">Sócio Ativo</label>
            <input type="radio" name="ativo" value="1" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->ativo=="1")? "checked" : "disabled" }} @else
                {{ ($user->ativo=="1")? "checked" : "" }}
                @endif  > Sim
        <input type="radio" name="ativo" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->ativo=="0")? "checked" : "disabled" }}  @else
            {{ ($user->ativo=="0")? "checked" : "" }}
                @endif > Não

        </div>

        <div>
            <label for="inputDirecao">Direção</label>
            <input type="radio" name="direcao"  value="1" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->direcao=="1")? "checked" : "disabled" }} @else
                {{ ($user->direcao=="1")? "checked" : "" }}
                    @endif > Sim
            <input type="radio" name="direcao" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) {{ ($user->direcao=="0")? "checked" : "disabled" }} @else
                {{ ($user->direcao=="0")? "checked" : "" }}
                    @endif> Não

        </div>

        <div>
            <label for="file_foto">Foto</label>
            <input type="file" name="file_foto">
        </div>


        @can('socio_DP', Auth::user())
        @if($user->tipo_socio=='P')


            <div>
                <label id="labelInputNrLicensa" for="inputNrLicenca"> Número de licença </label>
                <input type="text" name="num_licenca" id="inputNrLicenca"  value="{{$user->num_licenca}}">
            </div>


            <div>
                <label id="labelInputTipoLicensa"for="inputTipoLicenca">Tipo de licença</label>
                <select name="tipo_licenca" id="inputTipoLicenca">
                    @foreach($licencas as $licenca)
                        <option id="inputTipoLicenca" value="{{$licenca->code}}">{{$licenca->nome}}</option>
                    @endforeach

                </select>
                <a href="">{{$user->tipo_licenca}}</a>
            </div>




        </div>

        <div>
            <label id="labelinputAluno"for="inputAluno"> Aluno </label>
            <input type="text" name="aluno" id="inputAluno" value="{{$user->aluno}}">

        </div>

        <div>
            <label id="labelinputInstrutor"for="inputInstrutor"> Instrutor </label>
            <input type="text" name="instrutor" id="inputInstrutor" value="{{$user->instrutor}}">
        </div>

            <div>
                <label id="labeValidadeLicenca">Validade da licença</label>
                <input id="validade_licenca"type="date" name="validade_licenca" value="{{$user->validade_licenca}}" @if((Auth::user()->can('socio_piloto',App\User::class))) readonly @endif  >
            </div>

            <div>
                <label id="labelInputLicencaConfirmada"for="inputLicencaConfirmada">Licença confirmada</label>
                <input id="inputLicencaConfirmada1" type="radio" name="licenca_confirmada" value="1" @if((Auth::user()->can('socio_piloto',App\User::class))) {{ ($user->licenca_confirmada=="1")? "checked" : "disabled" }}@else
                        {{ ($user->licenca_confirmada=="1")? "checked" : "" }}
                        @endif > Sim
                <input type="radio"id="inputLicencaConfirmada2" name="licenca_confirmada" value="0" @if((Auth::user()->can('socio_piloto',App\User::class))) {{ ($user->licenca_confirmada=="0")? "checked" : "disabled" }} @else
                    {{ ($user->licenca_confirmada=="0")? "checked" : "" }}
                        @endif >Não

            </div>

            <div>
                <label id="labelCopia" for=""> Cópia digitial da licença </label>
                <a id="hrefDownload" href="{{route('licenca',$user->id)}}" class="btn btn-success mb-2"> Ver PDF</a>
                <a id="hrefDownload" href="{{route('licenca_pdf',$user->id)}}" class="btn btn-success mb-2"> Download</a>
                <input type="file" name="file_licenca">
            </div>

            <div>
                <label id="labelNrCerificado"for="inputNrCertificado"> Número de certificado </label>
                <input type="text" name="num_certificado" id="inputNrCertificado" @if((!Auth::user()->can('socio_piloto',App\User::class))) readonly @endif  value="{{$user->num_certificado}}">
            </div>


                <label for="inputClasseCertificado" id="labelCertificado">Classe do certificado </label>
                <select name="classe_certificado" id="classe_certificado">
                    @foreach($classes as $classe)
                        <option id="inputClasseCertificado" value="{{$classe->code}}">{{$classe->nome}}</option>
                    @endforeach


                </select>
                 <label for="" id="">{{$user->classe_certificado}} </label>
                <div>
                    <label id="validade_certificado">Validade do certificado </label>
                    <input type="date" id="inputValidadeCertificado" name="validade_certificado" value="{{$user->validade_certificado}}" @if((Auth::user()->can('socio_piloto',App\User::class))) readonly @endif  >
                </div>

                <div>
                    <label id="labelCertificadoConfirmado" for="inputCertificadoConfirmado">Certificado confirmado</label>
                    <input  id="inputCertificadoConfirmado" type="radio" name="certificado_confirmado" value="1" @if((Auth::user()->can('socio_piloto',App\User::class))) {{ ($user->certificado_confirmado=="1")? "checked" : "disabled" }}@else
                        {{ ($user->certificado_confirmado=="1")? "checked" : "" }}
                            @endif   > <label id="confirmado">Sim</label>
                    <input type="radio"id="inputCertificadoPorConfirmar" name="certificado_confirmado" value="0" @if((Auth::user()->can('socio_piloto',App\User::class))) {{ ($user->certificado_confirmado=="0")? "checked" : "disabled" }} @else
                        {{ ($user->certificado_confirmado=="0")? "checked" : "" }}
                            @endif  > <label id="naoConfirmado">Não</label>

                </div>

                <div>
                    <label id="labelCopiaDigital"> Cópia digital certificado </label>
                    <a id="hrefDownload" href="{{route('certificado',$user->id)}}" class="btn btn-success mb-2"> Ver PDF</a>
                    <a id="hrefDownload" href="{{route('certificado_pdf',$user->id)}}" class="btn btn-success mb-2"> Download</a>
                    <input type="file" name="file_certificado">
                 </div>

              <div>


               {{--<a class="btn btn-xs btn-primary" href="{{ route('socios.sendEmail', $user->id) }}">Send Email</a>--}}




              </div>

                    @endif
                  @endcan

              <div>
                  <button class="btn btn-xs btn-primary" type="submit" name="ok">Save</button>
                  <button type="button" class="btn btn-primary" onclick="window.history.back();">Cancel</button>
              </div>
      </form>

  @endsection