@extends('master')
@section('content')

    @if (count($errors) > 0)
        @include('shared.errors')
    @endif

    <form method="POST" action="{{route('socios.update', $user->id)}}" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div>

            <div>
                <label for="num_socio">Número de socio</label>
                <input id="num_socio" type="text" name="num_socio" value="{{ $user->num_socio }}" >
            </div>

            <div><label for="inputName">Nome Completo</label>
                <input type="text" name="name" id="inputName" placeholder="Name"
                       value="{{ $user->name }}"></div>

            <div><label for="inputNomeInformal">Nome Informal</label>
                <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="NomeInformal" value="{{$user->nome_informal}}"></div>

            <div><label for="inputSexo">Sexo</label>
                <select name="sexo" id="inputSexo" >
                    <option value="F" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif
                        {{ ($user->sexo=="F")? "selected" : "" }}  >Feminino</option>
                    <option value="M" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif
                            {{ ($user->sexo=="M")? "selected" : "" }}>Masculino</option>
                </select></div>


            <div>
                <label >Data nascimento</label>
                <input type="date" name="data_nascimento" value="{{$user->data_nascimento}}">
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

                    <option value="P" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif {{($user->tipo_socio=="P")? "selected" : "" }}>Piloto</option>
                    <option value="NP"@if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif {{($user->tipo_socio=="NP")? "selected" : "" }}>Não Piloto</option>
                    <option value="A" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif{{($user->tipo_socio=="A")? "selected" : "" }}>Aeromodelista</option>
                </select>
            </div>

            <div>
                <label for="inputQuotaPaga"  >Quotas em dia</label>
                <input type="radio" name="quota_paga" value="1" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif {{ ($user->quota_paga=="1")? "checked" : "" }} > Sim
                <input type="radio" name="quota_paga" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif{{ ($user->quota_paga=="0")? "checked" : "" }}> Não

            </div>


            <div>
                <label for="inputEndereco">Endereço</label>
                <textarea type="text" name="endereco" id="inputEndereco">{{$user->endereco}} </textarea>
            </div>

            <div>
                <label for="inputAtivo">Sócio Ativo</label>
                <input type="radio" name="ativo" value="1" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif {{ ($user->ativo=="1")? "checked" : "" }} > Sim
                <input type="radio" name="ativo" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif{{ ($user->ativo=="0")? "checked" : "" }}> Não

            </div>

            <div>
                <label for="inputDirecao">Direção</label>
                <input type="radio" name="direcao"  value="1" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif{{ ($user->direcao=="1")? "checked" : "" }} > Sim
                <input type="radio" name="direcao" value="0" @if((Auth::user()->can('socio_normal',App\User::class))) disabled @endif{{ ($user->direcao=="0")? "checked" : "" }}> Não

            </div>



            <div><label for="file_foto">Foto</label>

                <input type="file" name="file_foto" accept="image/*">
            </div>

        </div>
        <div>
            <button class="btn btn-xs btn-primary" type="submit" name="ok">Save</button>
            <button class="btn btn-xs btn-primary" type="submit" name="cancel">Cancel</button>
        </div>
    </form>

@endsection