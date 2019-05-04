@extends('master')
@section('content')

    <form action="{{action('MovimentoController@store')}}" method="post">
        @csrf
         <div>
              <label for="inputID">ID</label>
              <input type="text" name="id" id="inputID" placeholder="id" >
          </div>
          <div>
  <label >Aeronave</label>
       <select name="members">       
              
              @foreach ($aeronaves as $aeronave) 
                 <option value="{{ $aeronave->matricula }}"> {{ $aeronave->matricula }} </option>
      @endforeach    </select>


      
              
  <br>
               <label>Natureza</label>    

      
              
     <select name="natureza">                 
       <option value="I">I</option>   
       <option value="T">T</option>
       <option value="E">E</option>
   





 






              </select>


     





          </div>
         
          <div>
              <button type="submit" name="ok">Save</button>

          </div>




    </form>

@endsection