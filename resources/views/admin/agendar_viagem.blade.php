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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/agendar_viagem.css') }}">
    {{--    css jquery ui--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet"/>
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
{{--msg da pagina--}}
<div id="msg-dialog" title="">
    <p></p>
</div>
{{--fim msg da pagina--}}
<div class="container">
    <div class="row" style="margin-top: 15px">
        <div class="col-md-12">
            <div class="progress">
                <div class="progress-bar btn-verde active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            {{--            class="needs-validation viagem" novalidate--}}
            <form id="regiration_form" class="viagem"  action="{{route('admin.agendar.viagem')}}"  method="post">
                @csrf
                <fieldset>
                    <h2>Cadastre uma nova viagem</h2>
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="origem">Origem</label>
                            <input type="text" class="form-control required" name="origem" placeholder="Parnaiba-PI" id="origem" data-nome="origem">

                        </div>
                        <div class="col-md-6">
                            <label for="destino">Destino</label>
                            <input type="text" class="form-control required" name="destino" placeholder="Parnaiba-PI" id="destino" data-nome="destino">

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <label for="lorigem">Local Origem</label>
                            <input type="text" class="form-control required" name="lorigem" placeholder="Casa, hotel etc"  id="lorigem" data-nome="local origem">
                        </div>
                        <div class="col-md-4">
                            <label for="ldestino">Local Destino</label>
                            <input type="text" class="form-control required" name="ldestino" placeholder="Casa, hotel etc" id="ldestino" data-nome="local_destino">

                        </div>
                        <div class="col-md-4">
                            <label for="preco">Preço</label>
                            <input type="text" class="form-control required" name="preco" placeholder="200.50" id="preco" data-nome="preco">
                            <small id="emailHelp" class="form-text text-muted">Use o "." como separador decimal</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="dinicio">Data inicio</label>
                            <input type="date" class="form-control required" name="dinicio" id="dinicio" data-nome="data inicio">

                        </div>
                        <div class="col-md-6">
                            <label for="hinicio">Hora inicio</label>
                            <input type="time" class="form-control required" name="hinicio" id="hinicio" data-nome="Hora inicio">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="fornecedor">Fornecedor || Operadora</label>
                            <input type="text" class="form-control required" name="fornecedor" placeholder="emailforncedor@exemplo.com" id="fornecedor" data-nome="fornecedor || operadora" list="emails">

                            <datalist id="emails">
                                @foreach($fornecedor as $f)
                                    <option value="{{$f->email}}"></option>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-12">
                            <label for="observacoes">Observações</label>
                            <textarea class="form-control required" name="observacoes" id="observacoes" rows="10" data-nome="observações"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end" style="margin: 10px 0">
                        <input type="button" name="password" class="next btn btn-info" value="Proxima Etapa" />
                    </div>
                </fieldset>

                <fieldset>
                    <h2>Selecione os clientes e depedentes</h2>
                    <div id="marcador">
                        <div class="form-row clientes" id="cl-1">
                            <div class="col-md-6">
                                <label>Telefone do cliente</label>
                                <input type="text" class="form-control required" name="telefone" placeholder="Telefone do Cliente" data-nome="telefone cliente" list="telefones">
                                <datalist id="telefones">
                                    @foreach($cliente as $c)
                                        <option value="{{$c->telefone}}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                            <div class="col-md-6">
                                <label for="dependente_quantidade">Quantidade dependentes</label>
                                <input type="number" class="form-control required" name="dependente_quantidade" min="0"  placeholder="0" id="dependente_quantidade" data-nome="quantidade dependentes">
                            </div>
                        </div>
                        {{-- div de acordions --}}

                    </div>

                    <div class="d-flex justify-content-end" style="margin: 10px 0">
                        <input type="button" name="previous" class="previous btn btn-info" value="Voltar" style="margin-right: 10px" />
                        <input type="button" name="next" class="next btn btn-info" value="Proxima Etapa" />
                    </div>
                </fieldset>


                <fieldset>
                    <h2>Selecione os motoristas e veiculos</h2>
                    <div>
                        <div id="marcador2">
                            <div class="form-row veiculos-motorista" id="mt-1">
                                <div class="col-md-5" class="mt-1">
                                    <label for="m_cpf">Nome Motorista</label>
                                    <input type="text" class="form-control" value="" id="motorista" data-nome="Nome motorista 1">
                                </div>
                                <div class="col-md-5" class="mt-1">
                                    <label for="vc">Placa || Indetificação do veiculo</label>
                                    <input type="text" class="form-control placa" value="" id="veiculo" placeholder="Placa || Indetificação" data-nome="Placa || Indetificação do veiculo 1">
                                </div>
                                <div class="col-md-2 mt-1" >
                                    <button type="button" id="btn-add" style="margin-top:28px;"  class="btn btn-verde btn-block add_mt" ><i class="fas fa-user-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3 mt-3 table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-verde">
                                    <tr>
                                        <th scope="col">Motorista</th>
                                        <th scope="col">Placa || Indentificação</th>
                                        <th scope="col">Remover</th>
                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end" style="margin: 10px 0">
                            <input type="button" name="previous" class="previous btn btn-info" value="Voltar" style="margin-right: 10px" />
                            <button type="submit" id="load-ajax" class="btn btn-verde">Finalizar Agendamento <img src="{{asset('img/loading.gif')}}" class="img-fluid"/></button>
                        </div>

                    </div>
                </fieldset>
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
<script src="{{ asset('js/admin/agendar_viagem.js') }}"></script>
<script type="text/javascript">
    $(function (e) {
        $("form.viagem").submit(function (e) {
            e.preventDefault();
            // verfica campos nulos
            if($("input.nome_mot").length == 0){
                $("#msg-dialog p").html("Adicione pelo menos um motorista e veiculo");
                $("#msg-dialog").attr('title','Campo nulo ou inexistente');
                $("#msg-dialog").dialog();
                return;
            }
            let campo = $('.required');
            let quantidade = $(campo).length;
            for (let i=0; i < quantidade; i++){
                if ($(campo).eq(i).val() == ""){
                    let nome = $(campo).eq(i).attr('data-nome');
                    $("#msg-dialog p").html("O campo "+nome+" esta vazio!");
                    $("#msg-dialog").attr('title','Campo nulo ou inexistente');
                    $("#msg-dialog").dialog();
                    return;
                }
            }
            //envio ajax
            let dados = $(this).serialize();
            //add img de load
            $("button#load-ajax img").css('display','inline-block');
            // setTimeout(function (e) {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: dados,
                complete: function() {
                    //remove img
                    $("button#load-ajax img").css('display','none');
                },
                success: function (e) {
                    if(e == 1){
                        $("#msg-dialog p").html("Viagem agendada com sucesso, aguarde 5s");
                        $("#msg-dialog").attr('title','Agedamneto bem sucedido');
                        $("#msg-dialog").dialog();
                        setTimeout(function () {
                            window.location.reload();
                        },5000);
                    }else{
                        $("#msg-dialog p").html(e);
                        $("#msg-dialog").attr('title','Erro no agendamento!');
                        $("#msg-dialog").dialog();
                    }
                },
                error: function(e){
                    alert("ajax erro!");
                }
            });
            // },4500);

        });
        //autocomplete motorista
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
                "<img src='"+item.img+"' class='img-fluid ft-motorista'>" +
                "<span>"+item.value+"</span>" +
                "</div>" +
                "</li>" ).appendTo( ul );
        };
        //autocomplete veiculo
        $(".placa").autocomplete({
            source: //"autocomplete.php",
                [
                        @foreach($veiculo as $v)
                    {
                        id:"{{$v->id_veiculo}}",
                        value:"{{$v->placa}}",
                        label:"{{$v->placa}}",
                        img:"{{asset($v->foto_carro)}}"
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
                "<img src='"+item.img+"' class='img-fluid ft-veiculo'>" +
                "<span>"+item.value+"</span>" +
                "</div>" +
                "</li>" ).appendTo( ul );
        };
    })
</script>
</body>
</html>
