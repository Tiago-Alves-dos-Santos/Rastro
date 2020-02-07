<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/componentes/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/viagem_unica.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@include('componentes.menu')
<div class="container">

    <div class="row mt-3 mb-3">
        <div class="col-md-12">
            <h1 id="titulo" style="text-align: center">{{$viagem_unica->origem}} - {{$viagem_unica->destino}}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6" id="cliente">
            <h2>Cliente</h2>
            <ul style="list-style: none">
                <li>Nome: {{$viagem_unica->nome_cliente}}</li>
                @if($viagem_unica->passaporte == "")
                    <li>CPF: {{$viagem_unica->cpf_cliente}}</li>
                @elseif($viagem_unica->cpf_cliente == "")
                    <li>Passaporte: {{$viagem_unica->passaporte}}</li>
                @endif
                <li>Dependentes: {{$viagem_unica->quantidade_dependente}}</li>
            </ul>
        </div>
        <div class="col-md-6" id="fornecedor">
            <h2>Fornecedor</h2>
            <ul style="list-style: none">
                <li>Nome: {{$viagem_unica->nome_fornecedor}}</li>
                <li>Email: {{$viagem_unica->email}}</li>
                <li>Telefone: {{$viagem_unica->telefone}}</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2>Viagem</h2>
        </div>
        <div class="col-md-6">
            <ul style="list-style: none">
                <li>Data viagem: {{$viagem_unica->data_inicio}}</li>
                <li>Horario: {{$viagem_unica->horario_saida}}</li>
                <li>Local de origem: {{$viagem_unica->local_origem}}</li>
            </ul>
        </div>
        <div class="col-md-6">
            <ul style="list-style: none">
                <li>Local de destino: {{$viagem_unica->local_destino}}</li>
                <li>Status: {{$viagem_unica->status_viagem}}</li>
                <li>Valor da viagem: R$ {{$viagem_unica->preco}}</li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2>Motorista(s)</h2>
            @foreach($viagem_model as $vg)
            <div class="row">
                <div class="col-md-5">
                    <img src="{{asset($vg->foto)}}" class="img-fluid" style="width: 3cm; height: 4cm"/>
                </div>
                <div class="col-md">
                    <ul style="list-style: none;">
                        <li>Nome: {{$vg->nome_motorista}}</li>
                        <li>CPF: {{$vg->cpf_motorista}}</li>
                        <li>Agencia do banco {{$vg->agencia_banco}}</li>
                        <li>Conta do banco {{$vg->conta_banco}}</li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-6">
            <h2>Veículos(s)</h2>
            @foreach($viagem_model as $vg)
            <div class="row">
                <div class="col-md-4">
                    <img src="{{asset($vg->foto_carro)}}" class="img-fluid" style="width: 150px; height: 150px"/>
                </div>
                <div class="col-md">
                    <ul style="list-style: none">
                        <li>Placa: {{$vg->placa}}</li>
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@include('componentes.rodape')
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
</body>
</html>
