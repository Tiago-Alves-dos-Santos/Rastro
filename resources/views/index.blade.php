<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@if (session()->has('msg'))
    <div class="alert alert-success" id="msg-php" role="alert" style="text-align: center;">
        <h4>@php echo session("msg");@endphp</h4>
    </div>
@endif
<div class="row centralizar-hv-total">
    <div class="col-md-7 centralizar-vertical">
        <div class="form-body-login">
            <div class="foto-form centralizar-vertical">
                <img src="{{ asset('img/logo-rastro.png') }}" class="img-fluid">
            </div>
            <div class="form-body d-flex justify-content-center">
                <div class="form-campos" style="width: 80%">
                    <form class="needs-validation" novalidate method="post" action="{{ route('user.login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="exampleInputEmail1">Endereço de email:</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Digite seu login" required="" name="login">
                            <div class="valid-feedback">
                                Campo válido!
                            </div>
                            <div class="invalid-feedback">
                                Campo inválido!
                            </div>
                            {{-- <small id="emailHelp" class="form-text text-muted">Nunca vamos compartilhar seu email, com ninguém.</small> --}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Senha:</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Digite sua senha" required="" name="senha">
                            <div class="valid-feedback">
                                Campo válido!
                            </div>
                            <div class="invalid-feedback">
                                Campo inválido!
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-verde">Login</button>
                        </div>
                    </form>
                </div>
            </div>
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
<script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
