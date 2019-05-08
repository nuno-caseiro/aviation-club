  @extends('master')
  @section('content')

      <form action="{{action('MovimentoController@update', $movimento->id)}}" method="post" >
          @method('put')
          @csrf


          <div class="card-header">Editar Movimento</div>




          
          <div>
  <label >Aeronave</label>
       <select name="members">       
              
      @foreach ($aeronaves as $aeronave)//contem todos os dados das aeronaves para se for adicionada mais uma a sua matricula tb aparecer para ser selecionada
      <option value="{{ $aeronave->matricula }}" {{ ( $aeronave->matricula == $movimento->aeronave) ? 'selected' : $movimento->aeronave }}> {{ $aeronave->matricula }} </option>
    @endforeach    </select>


      
              
  <br>
               <label>Natureza</label>    

        

                  
  
              
               <select name="natureza">
                      
              <option value="{{ $movimento->natureza}}">{{$movimento->natureza}}</option>
      
      @if ($movimento->natureza!='I')
       <option value="I">Instruçao</option>
      @endif

      @if ($movimento->natureza!='T')
       <option value="T">Treino</option>
      @endif

      @if ($movimento->natureza!='E')
       <option value="E">Especial</option>
      @endif 

      </select>
        <div>
              <label for="inputID">Confirmado</label>
              <input type="text" name="confirmado" id="inputConfirmado" value="{{ $movimento->confirmado }}" >
          </div>

           <div>
              <label for="inputPiloto">Piloto</label>
              <input type="text" name="piloto" id="inputPiloto" value="{{ $movimento->piloto_id }}" >
          </div>


           <div>
              <label for="inputID">Instrutor</label>
              <input type="text" name="instrutor" id="inputIntrustorID" value="{{ $movimento->instrutor_id }}" >
          </div>


          






          </div>
         
          <div>
              <button type="submit" name="ok">Save</button>

          </div>
      </form>

      @endsection
