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
            <h2 style="cursor: pointer;">Filtros Veiculos <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.filter.veiculo')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="localizador">Placa || Indentificação</label>
                        <input type="text" name="placa" class="form-control" id="localizador" placeholder="ABC-1234">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="destino">Propietario</label>
                        <input type="text" name="propietario" placeholder="Propietario" class="form-control" id="destino">
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>Disponibilidade</label>
                        <select class="custom-select" name="disponibilidade">
                            <option value="">Selecione para busca</option>
                            <option value="Agendada">Agendado</option>
                            <option value="Em andamento">Em uso</option>
                            <option value="Concluida">Disponivel</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Vinculo</label>
                        <select class="custom-select" name="vinculo">
                            <option value="">Selecione para busca</option>
                            <option value="Externo">Externo</option>
                            <option value="Interno">Interno</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-verde btn-lg btn-block">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
        <div class="col-md-3">
            <a href="{{ route('read.veiculo') }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtros))
                {{$veiculo->appends($filtros)->links()}}
            @else
                {{$veiculo->links()}}
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="button" class="btn btn-danger btn-block" value="Emitir relatorio">
        </div>
    </div>
    <div class="row" style="margin-top: 30px">
        @forelse($veiculo as $v)
            {{-- expr --}}

            {{-- expr --}}
            <div class="col-md-12" style="margin:15px 0">
                <div class="card">
                    <div class="card-header">
                        Localizador: {{$v->id_veiculo}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h5 class="card-title">{{$v->placa}}</h5>
                        </div>
                        {{-- "card-text" --}}
                        <div class="row">
                            <div class="col-md-6">
                                <ul style="list-style: none;">
                                    <li class="card-text">Marca: {{$v->marca}}</li>
                                    <li class="card-text">Modelo: {{$v->modelo}}</li>
                                    <li class="card-text">Propietario: {{$v->propietario}}</li>
                                    <li class="card-text">Ano: {{$v->ano}}</li>
                                    <li class="card-text">Capacidade máxima: {{$v->capacidade_maxima}}</li>
                                    <li class="card-text">Vinculo: {{$v->vinculo}}</li>
                                    <li class="card-text">Tipo: {{$v->tipo}}</li>
                                    <li class="card-text">Disponibilidade: {{$v->disponivel}}</li>
                                </ul>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center">
                                <a href="{{ asset($v->foto_carro) }}" data-title="{{$v->modelo}} || {{$v->placa}}" data-alt="{{$v->modelo}}" data-lightbox="{{$v->id_veiculo}}">
                                    <img src="{{ asset($v->foto_carro) }}" class="img-fluid" style="width: 100px; height: 100px; max-width: 150px;max-height: 150px; border:1px solid rgba(108, 140, 59,1);" alt="{{$v->modelo}}" title="{{$v->modelo}}">
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="{{ route('alter.veiculo',['id' => $v->id_veiculo]) }}" class="btn btn-orange">Alterar Veiculo</a>
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
            @if(isset($filtros))
                {{$veiculo->appends($filtros)->links()}}
            @else
                {{$veiculo->links()}}
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
<script src="{{ asset('js/admin/consultar_veiculo.js') }}"></script>
</body>
</html>
