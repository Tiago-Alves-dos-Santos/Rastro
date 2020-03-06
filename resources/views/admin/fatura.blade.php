<!DOCTYPE html>
<html lang="en">
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
<div class="container">
    <div class="row" style="margin-top: 15px">
        <div class="col-md-12" style="text-align: center">
            <h2>Emitir Fatura, fornecedor: {{$fornecedor->nome}} </h2>
        </div>
        <div class="col-md-12 d-flex justify-content-center">

            
        <form style="width: 700px" class="needs-validation" action="{{route('admin.fatura')}}" method="POST">
                @csrf
            <input type="hidden" name="id_fornecedor" value="{{$fornecedor->id_fornecedor}}"/>
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="fatura">Data de expedição</label>
                        <input type="date" class="form-control" name="expedicao" id="fatura" required/>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="vencimento">Data de vencimento</label>
                        <input type="date" class="form-control" name="vencimento" id="vencimento" required/>
                    </div>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-block btn-danger" name="btn_fatura" value="Emitir Fatura" formtarget="_blank"/>
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
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/consultar_fornecedor.js') }}"></script>
</body>
</html>