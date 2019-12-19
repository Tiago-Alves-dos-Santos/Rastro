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
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <h1 style="margin-top: 40px; margin-bottom: 30px; text-align: center">Cadastro de motorista</h1>


            <form class="needs-validation" novalidate method="post" action="{{ route('admin.create.motorista') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-row">
                    <div class="col-md-12 mb-2" style="text-align: center">
                        <img style="width: 3cm; height: 4cm" src="{{ asset('upload/motorista/foto_padrao.png') }}" id="preview" class="img-thumbnail img-fluid">
                    </div>

                    <div class="col-md-12 mb-2">
                        <input type="file" name="ft_motorista" class="file" id="arquivo" accept=".jpg,.jpeg,.png" style="visibility: hidden; position: absolute;">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Selecione um arquivo de imagem" id="file-texto">
                            <div class="input-group-append">
                                <button type="button" class="browse btn" id="btn-up" style="background-color: rgb(108,140,59); color: white" >Selecionar</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" id="nome" placeholder="Seu nome" value="" required name="nome" pattern="^[A-z ]{1,}$">
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite um nome.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3" >
                        <label for="cpf">CPF</label>
                        <input type="text" class="form-control" id="cpf" placeholder="CPF" value="" required name="cpf">
                        <small style="font-size: 0.9em" id="cpf-msg" class="form-text text-muted">CPF é obrigatorio para o motorista!</small>
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite um cpf.
                        </div>
                    </div>

                    <div class="col-md-6 mb-3" >
                        <label for="rg">Vinculo com a empresa</label>
                        <select class="custom-select" name="vinculo" required="">
                            <option value="" selected>Selecione o vinculo do motorista</option>
                            <option value="Externo">Externo</option>
                            <option value="Interno">Interno</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Agencia</label>
                        <input type="text" name="agencia"  class="form-control" placeholder="Agencia" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Conta bancaria</label>
                        <input type="text" name="conta"  class="form-control" placeholder="Conta Bancaria" required>
                    </div>
                </div>

                <div style="text-align: right; margin-top: 20px; margin-bottom: 45px">
                    <button class="btn btn-verde btn-block" type="submit">
                        Cadastrar
                    </button>
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
<script src="{{ asset('js/admin/cadastrar_motorista.js') }}"></script>
</body>
</html>
