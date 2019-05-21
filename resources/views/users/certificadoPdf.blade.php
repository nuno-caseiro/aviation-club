

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

    <table class="table table-striped table-bordered" style="width: 100%" id="mydatatable">
        <thead>
        <tr>
            <th>Número do certificado</th>
            <th>Classe do certificado</th>
            <th>Validade do certificado</th>
            <th>Confirmação do certificado</th>



        </tr>
        </thead>
        <thead>

        <tr>
            <td>{{ $user->num_certificado}}</td>
            <td>{{ $user->classe_certificado}}</td>
            <td>{{ $user->validade_certificado}}</td>
            <td>{{ $user->certificado_confirmado}}</td>


        </tr>

        </thead>



    </table>
</body>
</html>