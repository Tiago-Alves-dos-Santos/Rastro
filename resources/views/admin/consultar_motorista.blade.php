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
    {{-- plugin lightbox --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/lightbox/lightbox.css') }}">
    {{-- fim do linnk do plugin lightbox --}}
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
            <h2 style="cursor: pointer;">Filtros Motorista <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.filter.motorista')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="destino">Nome:</label>
                        <input type="text" name="nome" class="form-control" id="destino" placeholder="Anoimo exemplo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nome">CPF</label>
                        <input type="text" name="cpf" class="form-control" id="origem" placeholder="000.000.000-00">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rg">Vinculo com a empresa</label>
                        <select class="custom-select" name="vinculo">
                            <option value="" selected>Selecione o vinculo do motorista</option>
                            <option value="Externo">Externo</option>
                            <option value="Interno">Interno</option>
                        </select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Disponibilidade</label>
                        <select class="custom-select" name="disponibilidade">
                            <option value="">Selecione para busca</option>
                            <option value="Agendada">Agendado</option>
                            <option value="Em andamento">Em uso</option>
                            <option value="Concluida">Disponivel</option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-verde btn-lg btn-block">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
        <div class="col-md-3">
            <a href="{{ route('read.motorista') }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtro))
                {{$motorista->appends($filtro)->links()}}
            @else
                {{$motorista->links()}}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <input type="button" class="btn btn-danger btn-block" value="Emitir relatorio">
        </div>
    </div>
    <div class="row" style="margin-top: 30px">
        @forelse($motorista as $m)
            {{-- expr --}}

            {{-- expr --}}
            <div class="col-md-12" style="margin:15px 0">
                <div class="card">
                    <div class="card-header">
                        Localizador: {{$m->id_motorista}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h5 class="card-title">{{$m->nome}}</h5>
                        </div>
                        {{-- "card-text" --}}
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="list-style: none;">
                                    <li class="card-text">CPF: {{$m->cpf}}</li>
                                    <li class="card-text">Agencia: {{$m->agencia_banco}}</li>
                                    <li class="card-text">Conta Bancaria: {{$m->conta_banco}}</li>
                                    <li class="card-text">Disponibiidade: {{$m->status_motorista}}</li>
                                    <li class="card-text">Vinculo: {{$m->vinculo}}</li>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                {{-- data-title='nome-padrao-para-paginar-fotos' --}}
                                <a href="{{ asset($m->foto) }}" data-title="{{$m->nome}}" data-alt="{{$m->nome}}" data-lightbox="{{$m->id_motorista}}">
                                    <img src="{{ asset($m->foto) }}" class="img-fluid" style="width: 3cm; height: 4cm; border:1px solid rgba(108, 140, 59,1);" title="{{$m->nome}}" alt="{{$m->nome}}">
                                </a>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="{{ route('read.despesa', ['id' => $m->id_motorista]) }}" class="btn btn-verde-black mr-2">Despesas</a>
                                <a href="{{ route('alter.motorista', ['id' => $m->id_motorista]) }}" class="btn btn-orange">Alterar Motorista</a>
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
                {{$motorista->appends($filtro)->links()}}
            @else
                {{$motorista->links()}}
            @endif
        </div>
    </div>
</div>
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('plugins/lightbox/lightbox.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/consultar_motorista.js') }}"></script>
</body>
</html>
