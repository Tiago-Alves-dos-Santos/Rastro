<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Viagem-{{$viagem_unica->id_viagem}}</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <style type="text/css">
        .font-h1{
            font-size: 20pt;
        }
        .font-h2{
            font-size: 15pt;
        }

        p{
            font-size: 12pt;
        }

        p.rodape{
            font-size: 12pt;
            font-weight: bold;
            text-transform: capitalize;
            display: block;
        }
        td{
            border: 1px solid black;
        }


    </style>
</head>
<body>
<table border='0' style="width: 100%" >
    <tr>
        <td style="border: none">
            <img src="https://www.rastronordestino.com/wp-content/themes/rastro/images/logo-rastro.png" style=""/>

        </td>
        <td style="text-align: right; border: none">
            <h1 style="text-decoration: underline;" class="font-h1">Ordem de serviço</h1>
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <h1 class="font-h1">Cliente:</h1>
            <p>
                {{$viagem_unica->nome_cliente}}
            </p>
        </td>

    </tr>

    <tr>
        <td>
            <h1 class="font-h1">Empresa/Prestador</h1>
            <h2 style="color: #1c7430" class="font-h2">Rastro Nordestino</h2>
        </td>
        <td>
            <h1 class="font-h1">Data e Hora do Serviço</h1>
            <p style="text-align: center">
                {{$viagem_unica->data_inicio}} as {{$viagem_unica->horario_saida}}
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <h1 class="font-h1">Veiculo(Placa||Indentifcação):</h1>
            @forelse($viagem_all as $v)
            <p style="display: block">
                {{$v->placa}}
            </p>
                @empty
                <h1>Erro! Dados inexistentes!</h1>
            @endforelse
        </td>

        <td>
            <h1 class="font-h1">Motorista:</h1>
            @forelse($viagem_all as $v)
                <p style="display: block">
                    {{$v->nome_motorista}}
                </p>
            @empty
                <h1>Erro! Dados inexistentes!</h1>
            @endforelse
        </td>
    </tr>
    <tr>
        <td>
            <h1 class="font-h1">Embarque</h1>
            <p>
                {{$viagem_unica->origem}}
            </p>
        </td>
        <td>
            <h1 class="font-h1">Desembarque</h1>
            <p>
                {{$viagem_unica->destino}}
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Observações</h1>
            <p>
                {{$viagem_unica->observacoes}}
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; border: none">
            <p class="rodape">Rastro Nordestino Ecoturismo e Aventura</p>
            <p class="rodape" style="display: block">
                CNPJ: 97.546.568./0001-4/ Cadastur 97.546.568/0001-44
            </p>
            <p class="rodape" style="font-weight: normal; text-transform: none">
                End. AV. Pinheiro Machado, Nº S/N, Baiiro Rodoviária, Box 07. Parnaíba - PI,
                Fone: (86) 999.327.313.
            </p>
        </td>
    </tr>
</table>


</body>
</html>
