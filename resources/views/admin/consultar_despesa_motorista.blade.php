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
            <h2 style="cursor: pointer;">Filtros Despesas <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.filter.despesa')}}">
                @csrf
                <input type="hidden" name="id_motorista" value="{{$id}}">
                <div class="form-row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="nome">Mes/Ano</label>
                        <input type="month" name="mes" class="form-control" id="origem" >
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="dispoinvel">Valor</label>
                        <input type="text" name="preco" placeholder="250.23" class="form-control" id="disponivel">
                        <small id="emailHelp" class="form-text text-muted">Use o "." como separador decimal</small>
                    </div>

                </div>

                <button type="submit" class="btn btn-verde btn-lg btn-block mb-3">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px; margin-bottom: 15px;">
        <div class="col-md-3">
            <a href="{{ route('read.despesa', ['id' => $id]) }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtro))
                {{$despesa->appends($filtro)->links()}}
            @else
                {{$despesa->links()}}
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.salario')}}">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label>Calcular salario mensal</label>
                        <input type="month" name="salario" class="form-control" required>
                    </div>
                    <input type="hidden" name="id_motorista" value="{{$id}}">
                </div>
                <input type="submit" formtarget="_blank" class="btn btn-danger btn-block" value="Calcular Salario">
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 30px">
        @forelse ($despesa as $d)
            {{-- expr --}}

            {{-- expr --}}
            <div class="col-md-12" style="margin:15px 0">
                <div class="card">
                    <div class="card-header">
                        Localizador: {{$d->id_dispesas}}
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-center">
                            <h5 class="card-title">{{$d->descricao}}</h5>
                        </div>
                        {{-- "card-text" --}}
                        <div class="row">
                            <div class="col-md-12">
                                <ul style="list-style: none;">
                                    <li class="card-text">Dia: {{$d->data}}</li>
                                    <li class="card-text">Valor: {{$d->preco}}</li>
                                </ul>
                            </div>

                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-end">
                                <a href="" class="btn btn-danger mr-2" data-id-despesa="{{$d->id_dispesas}}" id="btn_excluir_despesa">Excluir</a>
                                <a href="{{route('alter.despesa', ['id_despesa' => $d->id_dispesas, "id_motorista" => $id])}}" class="btn btn-orange">Alterar</a>
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
                {{$despesa->appends($filtro)->links()}}
            @else
                {{$despesa->links()}}
            @endif
        </div>
    </div>
    {{--    Modal de exclusao de despesa--}}
    <div class="modal fade" id="excluirDespesa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Exclusão de despesa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation novalidate" id="form-delete-despesa" method="post" action="{{route('admin.excluir.despesa')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <h4>Realmente deseja fazer a exclusão dessa despesa?</h4>
                            </div>
                            <div class="col-md-12 justify-content-end">
                                <input type="hidden" id="inp_id_despesa" name="id_despesa" value="">
                                <input type="hidden" id="" name="id_motorista_excluir" value="{{$id}}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-verde" data-dismiss="modal">NÃO</button>
                    <button type="button" class="btn btn-danger" id="confirma_exclusao_despesa">SIM</button>
                </div>
            </div>
        </div>
    </div>
    {{--    Fim do modal exclusao de despesa--}}
</div>
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/consultar_despesa_motorista.js') }}"></script>
</body>
</html>
