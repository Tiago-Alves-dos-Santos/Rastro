<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/componentes/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/consultar_viagem.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@include('componentes.menu')
@if (session()->has('msg'))
    <div class="alert alert-success msg-fixa" id="msg-php" role="alert" style="text-align: center;">
        <h4>@php echo session("msg");@endphp</h4>
    </div>
@endif
<div class="inicio centralizar-hv">
    <a href="#menu-nav"><i class="fas fa-arrow-circle-up fa-3x"></i></a>
</div>
<div class="container">
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 d-flex justify-content-center" id="form-filtro-controle">
            <h2 style="cursor: pointer;">Filtrar Clientes <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('user.filter.cliente')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control" id="origem" placeholder="Anonimo exemplo">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="destino">CPF:</label>
                        <input type="text" name="cpf" class="form-control" id="destino" placeholder="Senha">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="destino">Passaporte:</label>
                        <input type="text" name="passaporte" class="form-control" id="destino" placeholder="Passaporte">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="destino">Data nascimento:</label>
                        <input type="date" name="data" class="form-control" id="data">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="destino">Telefone</label>
                        <input type="text" name="tel" class="form-control" id="data">
                    </div>
                </div>

                <button type="submit" class="btn btn-verde btn-lg btn-block">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
        <div class="col-md-3">
            <a href="{{ route('read.cliente') }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtro))
                {{$cliente->appends($filtro)->links()}}
            @else
                {{$cliente->links()}}
            @endif
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <input type="button" class="btn btn-danger btn-block" value="Emitir relatorio geral">--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row" style="margin-top: 30px">
        @forelse($cliente as $c)
            {{-- expr --}}

            {{-- expr --}}
            <div class="col-md-12" style="margin:15px 0">
                <div class="card">
                    <div class="card-header">
                        Localizador: {{$c->id_cliente}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h5 class="card-title">{{$c->nome}}</h5>
                        </div>
                        {{-- "card-text" --}}
                        <div class="row">
                            <div class="col-md-12">
                                <ul style="list-style: none;">
                                    @if($c->cpf != "")
                                        <li class="card-text">CPF: {{$c->cpf}}</li>
                                    @else
                                        <li class="card-text">Passaporte: {{$c->passaporte}}</li>
                                    @endif
                                    <li class="card-text">Telefone: {{$c->telefone}}</li>
                                    <li class="card-text">País: {{$c->pais}}</li>
                                    <li class="card-text">Cidade: {{$c->cidade}}</li>
                                    <li class="card-text">Data Nasciemento: {{$c->data_nasc}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="{{ route('alter.cliente', ['id'=>$c->id_cliente]) }}" class="btn btn-orange">Alterar Cliente</a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer text-muted">
                      2 dias atrás
                    </div> --}}
                </div>

            </div>
        @empty
            <div class="col-md-12 d-flex justify-content-center">
                <h2>Nenhum dado encontrado!</h2>
            </div>
        @endforelse
    </div>

    <div class="row" style="margin:15px -10px">
        <div class="col-md-12 p-flex">
            @if(isset($filtro))
                {{$cliente->appends($filtro)->links()}}
            @else
                {{$cliente->links()}}
            @endif
        </div>
    </div>
</div>
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/usuario/consultar_cliente.js') }}"></script>
</body>
</html>
