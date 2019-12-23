<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Salario Motorista</title>
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
@php
    date_default_timezone_set('America/Sao_Paulo');
@endphp
<table border='0' style="width: 100%" >
    <tr>
        <td style="border: none">
            <img src="https://www.rastronordestino.com/wp-content/themes/rastro/images/logo-rastro.png" style=""/>

        </td>
        <td style="text-align: right; border: none">
            <h1 style="text-decoration: underline;" class="font-h1">Salario Motorista</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Motorista:</h1>
            <h2 class="font-h2">{{$motorista->nome}}</h2>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Viagens({{$mes}}), quantidade:</h1>
            @forelse($locais as $key => $value)
            <p style="display: block">
                {{$key}} -> {{$value}} {{($key > 1)?"vezes":"vez"}}
            </p>
                @empty
                <p>O motorista {{$motorista->nome}} não realizou viagens na data {{$mes}}</p>
            @endforelse
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Dia e preço das viagens</h1>
            @forelse($viagem_feitas as $v)
                <p style="display: block">
                    Embarque-Desembarque / {{$v->origem}} - {{$v->destino}}
                </p>
                <p style="display: block">
                    Data: {{$v->data_inicio}}
                </p>
                <p style="display: block">
                    Preço: R$ {{$v->preco}}
                </p>
            @empty
                <p>O motorista {{$motorista->nome}} não realizou viagens na data {{$mes}}</p>
            @endforelse
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Despesas do mes ({{$mes}}):</h1>
            @forelse($depesas as $d)
                <p style="display: block">
                    Motivo: {{$d->descricao}}
                </p>
                <p style="display: block;">
                    Dia: {{$d->data}}
                </p>
                <p style="display: block; border-bottom: 0.5px solid gray">
                    Preço: {{$d->preco}}
                </p>

            @empty
                <p>O motorista {{$motorista->nome}} não contem despesas na data {{$mes}}</p>
            @endforelse
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1 class="font-h1">Salario do mes</h1>
            @if($salario > 0)
                <p>
                    A receber: R$ {{$salario}}
                </p>
            @else
                <p>
                    A receber: R$ <span style="color: #fd2a2c">{{$salario}}</span>
                </p>

                <p style="font-size: 10pt; font-weight: bold; color: #fd2a2c">
                    *O salario esta em valor negativo!
                </p>
            @endif
            <p style="font-size: 10pt; font-weight: bold">
                O salario é baseado na soma das viagens menos o valor total das depesas!
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border: none; text-align: right">
            <p>
                Data Emissão: {{date('d/m/Y')}} as {{date('H:i:s')}} ||| Emitido por {{session('nome')}}
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
