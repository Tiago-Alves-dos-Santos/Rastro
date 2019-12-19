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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@include('componentes.menu')
@if (session()->has('msg'))
    <div class="alert alert-success msg-fixa" id="msg-php" role="alert" style="text-align: center;">
        <h4>@php echo session("msg");@endphp</h4>
    </div>
@endif
<div class="container">
    <div class="row centralizar-hv" style="margin-top: 75px">
        <div class="col-md-8">
            <h3 style="text-align: center;">Cadastrar Fornecedor</h3>
            <form class="needs-validation" novalidate="" method="post" action="{{ route('admin.create.fornecedor') }}">
                @csrf
                <div class="form-row">
                    <div class=" col-md-12">
                        <label for="nome">Nome:</label>
                        <input type="text" value="" name="nome" class="form-control" placeholder="Digite seu nome" required="" id="nome" pattern="^[A-z ]{1,}$">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" value="" name="telefone" required="" id="telefone" placeholder="+55 (88) 0 0000-0000">
                    </div>
                    <div class="col-md-6">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" value="" name="email" id="email" required="" placeholder="email@exemplo.com">
                    </div>
                </div>

                <div class="form-row" style="margin-top: 15px">
                    <div class="col-md-12">
                        <input type="submit" name="" value="Cadastrar" class="btn btn-verde btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('plugins/jquery_mask/jquery_mask.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/cadastrar_fornecedor.js') }}"></script>
</body>
</html>
