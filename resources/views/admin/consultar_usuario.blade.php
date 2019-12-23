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
            <h2 style="cursor: pointer;">Filtros de usuarios <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.filter.usuario')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome" id="origem" placeholder="Anonimo exemplo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="tipo_usuario">Tipo de usuario</label>
                        <select id="tipo_usuario" name="tipo_usuario" class="custom-select">
                            <option value="" selected>Selecione o tipo do usuario</option>
                            <option value="administrador">Administrador</option>
                            <option value="usuario">Usuario</option>

                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-verde btn-lg btn-block">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px; margin-bottom: 15px">
        <div class="col-md-3">
            <a href="{{ route('read.usuario') }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtro))
                {{$usuario->appends($filtro)->links()}}
            @else
                {{$usuario->links()}}
            @endif
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <input type="button" class="btn btn-danger btn-block" value="Emitir relatorio">--}}
{{--        </div>--}}
{{--    </div>--}}
    <div class="row" style="margin-top: 30px">
        @forelse($usuario as $u)
            {{-- expr --}}

            {{-- expr --}}
            <div class="col-md-12" style="margin:15px 0">
                <div class="card">
                    <div class="card-header">
                        Localizador: {{$u->id_usuario}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h5 class="card-title">{{$u->nome}}</h5>
                        </div>
                        {{-- "card-text" --}}
                        <div class="row">
                            <div class="col-md-12">
                                <ul style="list-style: none;">
                                    <li class="card-text">Login: {{$u->login}}</li>
                                    <li class="card-text">Senha: {{$u->senha}}</li>
                                    <li class="card-text">Cargo: {{$u->cargo}}</li>
                                    <li class="card-text">Tipo de usuario: {{$u->tipo_usuario}}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="{{ route('alter.usuario',['id'=> $u->id_usuario]) }}" class="btn btn-orange text-light">Alterar Usuario</a>
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
                {{$usuario->appends($filtro)->links()}}
            @else
                {{$usuario->links()}}
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
<script src="{{ asset('js/admin/consultar_usuario.js') }}"></script>
</body>
</html>
