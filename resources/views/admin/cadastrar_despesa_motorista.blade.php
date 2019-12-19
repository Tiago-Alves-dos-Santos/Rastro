<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/componentes/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin/cadastrar_despesa_motorista.css')}}"/>
    {{--    css jquery ui--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet"/>
    {{--    fim css jquery ui--}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{--    js jquery ui--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
@include('componentes.menu')

@if (session()->has('msg'))
    <div class="alert alert-success msg-fixa" id="msg-php" role="alert" style="text-align: center;">
        <h4>@php echo session("msg");@endphp</h4>
    </div>
@endif

<div class="container justify-content-center">
    <div class="row justify-content-center mt-2">
        <div class="col-md-8 mt-3">
            <div style="text-align: center">
                <h1>Incluir Despesa em motorista</h1>
            </div>

            <form  class="needs-validation" novalidate method="post" action="{{route('admin.create.despesa')}}">
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label>Busque o motorista</label>
                        <input type="text" id="motorista" name="motorista" class="form-control" placeholder="Nome do motorista" required>
                        {{--                        <small id="id_mt_help" class="form-text text-muted"></small>--}}
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Motivo da despesa</label>
                        <input type="text" name="motivo" class="form-control" placeholder="Gasolina, acidente no veiculo..." required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label>Preço da despesa</label>
                        <input type="text" name="preco" class="form-control" placeholder="200.5" required pattern="^[0-9 .]{1,}$">
                        <small id="emailHelp" class="form-text text-muted">Use o "." como separador decimal</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Dia do acontecimento</label>
                        <input type="date" name="data" class="form-control" placeholder="" required>
                    </div>


                    <div class="col-md-12 mb-3">
                        <input type="submit" class="btn btn-verde btn-block" value="Adicionar despesa">
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
<script src="{{'js/admin/cadastrar_despesa_motorista.js'}}"></script>
<script type="text/javascript">
    $(function () {
        $("#motorista").autocomplete({
            source: //"autocomplete.php",
                [
                        @foreach($motorista as $m)
                    {
                        id:"{{$m->id_motorista}}",
                        value:"{{$m->nome}}",
                        label:"{{$m->nome}}",
                        img:"{{asset($m->foto)}}"
                    },
                    @endforeach

                ],
            minLength: 1,
            select: function(event, ui) {

            },
            html: true,
            open: function(event, ui) {
                $(".ui-autocomplete").css("z-index", 1000);

            }
        })
            .autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $( "<li>" +
                "<div>" +
                "<img src='"+item.img+"' class='img-fluid'>" +
                "<span>"+item.value+"</span>" +
                "</div>" +
                "</li>" ).appendTo( ul );
        };
    })

</script>
</body>
</html>
