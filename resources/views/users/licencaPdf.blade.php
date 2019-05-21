<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
    <thead>
    <tr>
        <th>Número de Licença</th>
        <th>Tipo de Licença</th>
        <th>Instrutor</th>
        <th>Validade de licença</th>
        <th>Confirmação de licença</th>



    </tr>
    </thead>
    <thead>

        <tr>
            <td>{{ $user->num_licenca }}</td>
            <td>{{ $user->tipo_licenca }}</td>
            <td>{{ $user->instrutor}}</td>
            <td>{{ $user->validade_licenca}}</td>
            <td>{{ $user->licenca_confirmada}}</td>


        </tr>

    </thead>



</table>

</body>
</html>


