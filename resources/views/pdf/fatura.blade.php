<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <style type="text\css">
        h2,h3,h5{
            color:#546d2b;
        }
        h5{
            margin: 5px 0 5px 0;
        }
        table{
            width: 100%;
            /* border: 1px solid black; */
        }
        .tabelas-meio{
            margin-top: 15px;
        }
        .tabelas-meio td{
            border:1px solid black;
            text-align: center;
        }
        table#datas{
            font-weight: bold;
        }
        table#datas h2{
            font-weight: bold;
            font-size: 20px;
        }
        table#datas td h3{
            color:#546d2b;
        }
        table#corpo p{
            font-size: 18px;
        }
        table#rodape{

        }
        table#rodape td{
            border:none;
        }
        
    </style>
</head>
<body>
    <table style="border:none" id="cabecalho">
        <tr style="border:none">
            <td style="text-align: left">
                <img src="https://www.rastronordestino.com/wp-content/themes/rastro/images/logo-rastro.png" style="width: 300px"/>
            </td>
            <td style="text-align: right; color:#546d2b; font-weight: bold; font-size: 17px">
                George Souza de Oliveira – ME.<br>
                CNPJ: 97.546.568/0001-44<br>
                AV. Pinheiro Machado, S/N, Box 01 – Rodoviária.<br>
                Parnaíba-PI<br>
                Tel: +55 (86)3321-2193<br>
                E-mail: financeiro@rastronordestino.com
            </td>
        </tr>
    </table>

    <table id="fornecedor" class="tabelas-meio">
        <tr>
            <td>
                <h2>Cliente: {{$fornecedor_bd->nome}}</h2>
            </td>
        </tr>
    </table>

    <table id="datas" class="tabelas-meio">
        <tr>
            <td>
                <h2>Data de Expedição<h2>
            </td>
            <td>
                <h2>Data de Vencimento<h2>  
            </td>
            <td>
                <h2>Valor Total(R$)<h2>  
            </td>
        </tr>
        <tr>
            <td>
                <h3>{{$data_expedicao}}<h3>
            </td>
            <td>
                <h3>{{$data_vencimento}}<h3>  
            </td>
            <td>
                <h3>{{$valor_total}}<h3>  
            </td>
        </tr>
    </table>

    <table id="corpo" class="tabelas-meio">
        <tr>
            <td>
                <h2>Data de Execução</h2>
            </td>
            <td>
                <h2>Descrição</h2>
            </td>
            <td>
                <h2>Cliente</h2>
            </td>
            <td>
                <h2>Valor Unitário</h2>
            </td>
        </tr>
        {{-- Corpo de dados tabela --}}
        @forelse ($viagem_fornecedor as $viagem)
        <tr>
            <td>
                <p>{{$viagem->data_inicio}}</p>
            </td>
            <td>
                <p>{{$viagem->observacoes}}</p>
            </td>
            <td>
                <p>{{$viagem->nome_cliente}}</p>
            </td>
            <td>
                <p>{{$viagem->preco}}</p>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="4" style="text-align: center">
                    <h3>O cliente <span style="color: #03299e">{{$fornecedor_bd->nome}}</span> não possui dados neste mês</h3>
                </td>
            </tr>
        @endforelse
        
        {{-- Colocar campos em branco apos laço de repetiçao --}}
        <tr>
            <td>
                <h2>-</h2>
            </td>
            <td>
                <h2>-</h2>
            </td>
            <td>
                <h2>-</h2>
            </td>
            <td>
                <h2>-</h2>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <h2>VALOR TOTAL: R$ {{$valor_total}}<</h2>
            </td>
        </tr>
    </table>

    <table id="rodape" class="tabelas-meio">
        <tr>
            <td>
                <h5>GRATOS PELA PREFERÊNCIA POR NOSSOS SERVIÇOS!</h5>
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                <h5>Fatura enviada por: Verena Mota Vitorino<br>
                    DADOS BANCÁRIOS<br>
                     * Caixa Econômica Federal<br>
                     AGENCIA - 0030<br>
                     CONTA/DV - 2934-1<br>
                     Operação – 003
                    </h5>
                     
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <h5>Rastro Nordestino Ecoturismo e Aventura<br>
                    <span> AV. Pinheiro Machado, N.º S/N, Bairro Rodoviária, Box 01. Parnaíba – PI, Fone: (86) 3321-2193.</span>
                </h5>
                     
            </td>
        </tr>
        <tr>
            <td style="text-align: left">
                <h5 style="margin-bottom: 0">GEORGE SOUZA DE OLIVEIRA</h5>
                <h5 style="margin-top: 0">CNPJ: 97.546.568/0001-44</h5>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <h5 style="margin-bottom: 0">OBS.1: FAVOR ENVIAR COMPROVANTE DE PAGAMENTO APÓS O MESMO SER EFETUADO.</h5>
                <h5 style="margin-top: 0">OBS.2: CASO NECESSITE DE NOTA FISCAL, ACRESCENTAR 5% DO VALOR TOTAL.</h5>
            </td>
        </tr>
    </table>
</body>
</html>