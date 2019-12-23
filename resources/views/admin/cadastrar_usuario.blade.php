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
    <div class="row d-flex justify-content-center mt-4">
        <div class="col-md-8">
            <h1 style="text-align: center;">Cadastro de usuarios</h1>
            <form class="needs-validation" novalidate method="post" action="{{ route('admin.create.usuario') }}">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Seu nome" value="" required name="nome">
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite um nome.
                        </div>
                    </div>

                    <div class="col-md-12 mb-4" >
                        <label for="login">Login</label>
                        <input type="text" class="form-control" id="login" placeholder="Login de acesso" value="" required name="login">
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite um login.
                        </div>
                    </div>

                    <div class="col-md-12 mb-3" >
                        <label for="senha">Senha</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="senha" placeholder="Senha de acesso" aria-describedby="inputGroupPrepend" required name="senha" />
                            <div class="valid-feedback">
                                Tudo certo!
                            </div>
                            <div class="invalid-feedback">
                                Por favor, digite uma senha.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2" >
                        <label for="cargo">Cargo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cargo" placeholder="Cargo" aria-describedby="inputGroupPrepend" name="cargo" />
                            <div class="valid-feedback">
                                Tudo certo!
                            </div>
                            <div class="invalid-feedback">
                                Por favor, digite um cargo.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-2" >
                        <label for="tipo_usuario">Tipo de usuario</label>
                        <select id="tipo_usuario" name="tipo_usuario" class="custom-select" required="">
                            <option value="" selected>Selecione o tipo do usuario</option>
                            <option value="administrador">Administrador</option>
                            <option value="usuario">Usuario</option>

                        </select>
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor selecione o tipo do usuario!
                        </div>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 30px; margin-bottom: 45px">
                    <button class="btn btn-verde btn-block" type="submit">
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('componentes.rodape')
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/cadastrar_usuario.js') }}"></script>
</body>
</html>
