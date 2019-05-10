@extends('master')
@section('content')

    <form action="{{action('UserController@update', $user->id)}}" method="post">
        @method('put')
        @csrf

        <div>
            <label for="inputName">Nome Completo</label>
            <input type="text" name="name" id="inputName" placeholder="Name"
                   value="{{ $user->name }}">
            <br></br>       
            <label for="inputNomeInformal">Nome Informal</label>
            <input type="text" name="nome_informal" id="inputNomeInformal" placeholder="NomeInformal" value="{{$user->nome_informal}}">    
            <br></br>       
            <label for="inputEmail">Email</label>
            <input type="email" name="email" id="inputEmail" placeholder="Email" value="{{$user->email}}">    
        
            <br></br>       
            <label for="inputNif">NIF</label>
            <input type="text" name="nif" id="inputNif" placeholder="Nif" value="{{$user->nif}}">
            <br></br>       
            <label for="inputTelefone">Telefone</label>
            <input type="text" name="telefone" id="inputTelefone" placeholder="Telefone" value="{{$user->telefone}}">
            <br></br>       
            <label for="inputDataNascimento">Data Nascimento</label>
            <input type="date" name="data_nascimento" id="inputDataNascimento" placeholder="DataNascimento" value="{{$user->data_nascimento}}">
            <br></br>       
            <label for="inputEndereco">Endereço</label>
            <input type="text" name="endereco" id="inputEndereco" placeholder="Endereco" value="{{$user->endereco}}">   
            <br></br>  
            <label for="inputFoto">Foto</label>
            
            <input type="file" name="foto" accept="image/*">
            <br></br>

          
              
                
        </div>
        <div>
            <button class="btn btn-xs btn-primary" type="submit" name="ok">Save</button>
            <button class="btn btn-xs btn-primary" type="submit" name="cancel">Cancel</button>
        </div>
    </form>

    @endsection