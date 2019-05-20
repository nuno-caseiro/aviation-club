
<table class="table table-bordered" id="laravel_crud">
    <thead>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Description</th>


    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user>id }}</td>
            <td>{{ $user->nome }}</td>
            <td>{{ $user->nif }}</td>


        </tr>
    @endforeach
    </tbody>
</table>



