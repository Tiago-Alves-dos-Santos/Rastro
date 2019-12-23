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
    <div class="row centralizar-hv" style="margin-top:70px;">
        <div class="col-md-8">
            <h1 style="text-align:center;">Alterar Veiculo</h1>
            <form class="needs-validation" novalidate method="post" action="{{ route('admin.alter.veiculo') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_veiculo" value="{{$veiculo->id_veiculo}}">
                <div class="form-row">

                    <div class="col-md-12 mb-2" style="text-align: center">
                        <img style="max-width: 150px; max-height: 150px" src="{{ asset($veiculo->foto_carro) }}" id="preview" class="img-thumbnail">
                    </div>

                    <div class="col-md-12 mb-2">
                        <input type="file" name="ft_carro" class="file" id="arquivo" accept=".jpg,.jpeg,.png" style="visibility: hidden; position: absolute;">
                        <div class="input-group my-3">
                            <input type="text" class="form-control" disabled placeholder="Selecione um arquivo de imagem, para alterarção" id="file-texto">
                            <div class="input-group-append">
                                <button type="button" class="browse btn btn-verde" id="btn-up" >Selecionar</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3" >
                        <label for="vinculo">Tipo do veiculo</label>
                        <select class="custom-select" required="" name="tipo" id="tipo">
                            <option value="" selected>Selecione o tipo</option>
                            <option value="Carro">Carro</option>
                            <option value="Lancha">Lancha</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="placa">Placa || Indetificador</label>
                        <input type="text" minlength="1" class="form-control" id="placa" name="placa" placeholder="Indeticador ou placa do veiculo" pattern="^[_A-Z0-9-]{1,}$" value="{{$veiculo->placa}}" required style="text-transform: capitalize;" {{--readonly=""--}}>
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma placa.
                        </div>
                        <small id="help_preco" class="form-text text-muted">Digite a letras da placa em fonte alta</small>
                        <span id="casp-lock" style="font-size: 0.8em"></span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="marca">Marca</label>
                        <input type="text" class="form-control" id="marca" placeholder="Marca do veiculo" value="{{$veiculo->marca}}" name="marca" list="marcas" required>
                        <datalist id="marcas">
                            @foreach ($veiculo_marca as $v)
                                <option value="{{$v->marca}}"></option>
                            @endforeach
                        </datalist>

                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma marca.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="modelo">Modelo</label>
                        <input type="text" class="form-control" id="modelo" placeholder="Modelo do veiculo" value="{{$veiculo->modelo}}" name="modelo" list="modelos" required>

                        <datalist id="modelos">
                            @foreach ($veiculo_mod as $v)
                                <option value="{{$v->modelo}}"></option>
                            @endforeach
                        </datalist>
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma modelo.
                        </div>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="Proprietario">Proprietario</label>
                        <input type="text" class="form-control" id="Proprietario" placeholder="Proprietario" value="{{$veiculo->propietario}}" name="propietario" required>
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma Proprietario.
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label for="Ano">Ano</label>
                        <input type="number" class="form-control" id="Ano" placeholder="Ano" value="{{$veiculo->ano}}" required min="2001" max="<?php echo date('Y') + 1 ?>" name="ano">
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma Ano.
                        </div>
                    </div>

                    <div class="col-md-4 mb-3" >
                        <label for="Capacidade">Capacidade máxima</label>
                        <input type="number" class="form-control" id="Capacidade" placeholder="5" value="{{$veiculo->capacidade_maxima}}" required name="capacidade" min="2" max="10">
                        <div class="valid-feedback">
                            Tudo certo!
                        </div>
                        <div class="invalid-feedback">
                            Por favor, digite uma Capacidade.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3" >
                        <label for="vinculo">Vinculo do veiculo</label>
                        <select class="custom-select" required="" name="vinculo" id="vinculo">
                            <option value="" selected>Selecione o vinculo</option>
                            <option value="Interno">Interno</option>
                            <option value="Externo">Externo</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('read.veiculo') }}" class="btn btn-orange btn-block">Voltar</a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="submit" name="enviar" class="btn btn-verde btn-block" value="Salvar Alteração">
                    </div>
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
<script src="{{ asset('plugins/jquery_mask/jquery_mask.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/alterar_veiculo.js') }}"></script>

<script type="text/javascript">
    //setar selected em tipo do veiculo
    let tipo = $("select#tipo option");
    for(let i =0; i < $(tipo).length; i++){
        if ($(tipo).eq(i).val() == "{{$veiculo->tipo}}") {
            $(tipo).eq(i).attr('selected', "");
        }else{
            $(tipo).eq(i).removeAttr('selected');
        }
    }
    //setar selected em vinculo do veiculo
    let vinculo = $("select#vinculo option");
    for(let i =0; i < $(vinculo).length; i++){
        if ($(vinculo).eq(i).val() == "{{$veiculo->vinculo}}") {
            $(vinculo).eq(i).attr('selected', "");
        }else{
            $(vinculo).eq(i).removeAttr('selected');
        }
    }
</script>
</body>
</html>
