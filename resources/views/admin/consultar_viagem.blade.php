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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet"/>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).tooltip();
    </script>
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
            <h2 style="cursor: pointer;">Filtros de Viagem <i id="mais" class="fas fa-plus-circle"></i></h2>
        </div>
        <div class="col-md-12" id="form-filtro">
            <form class="needs-validation novalidate" method="post" action="{{route('admin.filter.viagem')}}">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="data_inicio">Data minima</label>
                        <input type="date" name="date_min" class="form-control" id="data_inicio">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="data_termino">Data maxima</label>
                        <input type="date" name="date_max" class="form-control" id="data_termino">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <label>Nome cliente</label>
                        <input type="text" name="cliente" class="form-control" name="id_cliente" value="" placeholder="Nome cliente">
                    </div>
                    <div class="col-md-6">
                        <label>Nome motorista</label>
                        <input type="text" name="motorista" class="form-control" name="id_motorista" value="" placeholder="Nome motorista">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Status da viagem</label>
                        <select class="custom-select" name="disponibilidade">
                            <option value="">Selecione para busca</option>
                            <option value="Agendada">Agendada</option>
                            <option value="Em andamento">Em andamento</option>
                            <option value="Concluida">Concluida</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-verde btn-lg btn-block">Filtrar</button>
            </form>
        </div>
    </div>

    <div class="row" style="margin-top: 15px">
        <div class="col-md-3">
            <a href="{{ route('read.viagem') }}" class="btn btn-verde">Buscar Todas</a>
        </div>
        <div class="col-md-9 d-flex justify-content-end ">
            @if(isset($filtro))
                {{$viagem_model->appends($filtro)->links()}}
            @else
                {{$viagem_model->links()}}
            @endif
        </div>
    </div>

    <div class="row" style="margin-top: 30px">

        @forelse($viagem_model as $viagem)
            @if($viagem->status_viagem != "Cancelada")
        <div class="col-md-12" style="margin:15px 0">
            <div class="card">
                <div class="card-header">
                    Localizador: {{$viagem->id_viagem}}
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <h5 class="card-title">{{$viagem->origem}} || {{$viagem->destino}}</h5>
                    </div>
                    {{-- "card-text" --}}
                    <div class="row">
                        <div class="col-md-6">
                            <ul style="list-style: none;">
                                <li class="card-text">Data da viagem: {{$viagem->data_inicio}} </li>
                                <li class="card-text">Horario: {{$viagem->horario_saida}}</li>
                                <li class="card-text">Local de origem: {{$viagem->local_origem}} </li>
                                <li class="card-text">Local de destino: {{$viagem->local_destino}}</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul style="list-style: none;">
                                <li class="card-text">Status: {{$viagem->status_viagem}}</li>
                                <li class="card-text">Preço: {{$viagem->preco}}</li>
                                <li class="card-text">Fornecedor(operadora): {{$viagem->nome_fornecedor}}</li>
                                <li class="card-text">Fornecedor(operadora) email: {{$viagem->email}}</li>
                            </ul>
                        </div>
                        <div style="background-color: rgba(209, 209, 209,.3); box-sizing: border-box; padding: 5px 10px; list-style:none;" class="col-md-12">
                            <h6 style="text-align: left;">Cliente pagante</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <li class="card-text">Nome: {{$viagem->nome_cliente}}</li>
                                    <li class="card-text">Total de dependentes: {{$viagem->quantidade_dependente}}</li>
                                </div>
                                <div class="col-md-6">
                                    @if($viagem->passaporte == "")
                                        <li class="card-text">CPF: {{$viagem->cpf_cliente}}</li>
                                    @elseif($viagem->cpf_cliente == "")
                                        <li class="card-text">Passaporte: {{$viagem->passaporte}}</li>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div style="background-color: rgba(209, 209, 209,.3); box-sizing: border-box; padding: 5px 10px; list-style:none;" class="col-md-12">
                            <h6 style="text-align: left;">Motorista(s) e veiculo(s)</h6>

                            <div class="row" id="conteudo-{{$viagem->id_viagem}}" style="position: relative; ">

                            </div>



                        </div>
                        <div class="col-md-12">
                            <h6>Observaões:</h6>
                            <p>{{$viagem->observacoes}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 d-md-flex justify-content-end">

                            <a href="" class="viagem-motoristas mb-2" data-viagem="{{$viagem->id_viagem}}" style="margin-right: 10px;color:black" title="Ver motoristas e veiculos da viagem {{$viagem->id_viagem}}"><i class="fas fa-eye fa-2x"></i></a>

                            @if(session("tipo_usuario") == "administrador")
                            <a href="" class="btn btn-danger mb-2 cancelar_viagem" data-viagem="{{$viagem->id_viagem}}" style="margin-right: 10px">Cancelar viagem</a>
                            @endif
                            <a href="{{route('viagem.search',['id' => $viagem->id_viagem])}}" class="btn btn-verde mb-2" style="margin-right: 10px">Mais Detalhes</a>
                            @if(session("tipo_usuario") == "administrador")
                            <a href="{{route('admin.pdf',['id' => $viagem->id_viagem])}}" target="_blank" class="btn btn-primary mb-2" id="pdf-viagem" style="margin-right: 10px">Ordem de Serviço</a>
                            @endif
                            @if(session("tipo_usuario") == "administrador" && $viagem->status_viagem != "Concluida")
                            <a href="{{route('alter.viagem',['id' => $viagem->id_viagem])}}" class="btn btn-warning text-light mb-2" class="alterar-viagem">Alterar Viagem</a>
                            @endif


                        </div>
                    </div>
                </div>
                {{-- <div class="card-footer text-muted">
                  2 dias atrás
                </div> --}}
            </div>
        </div>
            @endif
        @empty
            <div class="col-md-12 d-flex justify-content-center">
                <h2>Nenhum dado encontrado!</h2>
            </div>
        @endforelse
    </div>

    <div class="row" style="margin:15px -10px">
        <div class="col-md-12 p-flex">
            @if(isset($filtro))
                {{$viagem_model->appends($filtro)->links()}}
            @else
                {{$viagem_model->links()}}
            @endif
        </div>
    </div>
</div>
{{--modal de cancelmento de viagem--}}
<div class="modal fade" id="cancelarViagem" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Cancelar Viagem?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Após cancelar uma viagem ela sera como excluida, não afetara no calculo das despesas dos motoristas envolvidos na mesma e não aparecera no calendario de agendamento. <span style="color:red">Viagens canceladas não poderam ser restauradas!</span></h5>
                <h5>Senhor(a) {{session('nome')}} você realmente deseja cancelar esta viagem?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Não</button>
                <a href="" class="btn btn-danger" id="cancelar-viagem">Sim, quero cancelar! <img id="img-cancelar" src="{{asset('img/loading.gif')}}" class="img-fluid" style="width: 20px; height: 20px; display: none"></a>
            </div>
        </div>
    </div>
</div>

@include('componentes.rodape')
{{--fim do modal cancelamneto de viagem--}}
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/consultar_viagem.js') }}"></script>

<script>
    //varivel usada para saber se os motoristas e veiculos estao sendo exibidos
    let visible = false;
    //requisao ajax para ver motoristas de uma viagem
    $(".viagem-motoristas").click(function (e) {
        e.preventDefault();
        let id_viagem =  parseInt($(this).attr('data-viagem'));
        //caso estejam sendo visto e o usario clicar os motoristas e veiculos iram sumir
        if(visible){
            $("#conteudo-"+id_viagem).html("");
            visible = false;
            $(this).html("<i class='fas fa-eye fa-2x'></i>");
            $(this).attr('title','Ver motoristas e veiculos da viagem '+id_viagem);
            return;
        }else{
            //casom os motorisa estejam sendo escondidos iram mostrar
            $(this).html("<i class='fas fa-eye-slash fa-2x'></i>");
            $(this).attr('title','Ocultar motoristas e veiculos da viagem '+id_viagem);
        }
        $.ajax({
            //tipo de envio
            type: 'GET',
            //local de execuão codigo php,o retorno devera estar contido nessa pagina php
            url: "{{route('admin.viagem.search')}}",
            //dados dos formulario, nao obrigatorio(depende do caso)
            data: {'id_viagem':id_viagem},
            //caso de certo, oq faz
            //parametro 'e' faz referencia ao retorno na pagina citada na url
            success: function (e) {
                let html = "";
                for(let i =0; i < e.length;i++){
                    html += " <div class='col-md-6'>\n" +
                        "     <li class='card-text'>Nome: "+e[i].nome_motorista+"</li>\n" +
                        "     <li class='card-text'>CPF: "+e[i].cpf_motorista+"</li>\n" +
                        "     </div>\n" +
                        "     <div class='col-md-6'>\n" +
                        "      <li class='card-text'>Placa "+e[i].placa+"</li>\n" +
                        "      </div>\n" +
                        "\n" +
                        "<div style='border-bottom: 0.5px solid black; width: 100%;'></div>"+
                        "     </div>\n" +
                        "\n";
                }
                visible = true;
                $("#conteudo-"+id_viagem).html(html);

            },
            error: function () {
                alert("Erro ajax");
            }
        });

    })
    //abre o modal realcionado a viagem que foi clicada
    $("a.cancelar_viagem").click(function (e) {
        //data-viagem == id
        //data-dia-viagem == dia
        e.preventDefault();
        let id = $(this).attr('data-viagem');
        $("a#cancelar-viagem").attr('data-viagem', id);
        $("#cancelarViagem").modal('show');
    });
    //realiza o canlamento da viagem por requisiçao
    $("a#cancelar-viagem").click(function (e) {
        e.preventDefault();
        $("#img-cancelar").css('display','inline-block');
        let id = $(this).attr('data-viagem');
        $.ajax({
            //tipo de envio
            type: 'GET',
            //local de execuão codigo php,o retorno devera estar contido nessa pagina php
            url: "{{route('admin.cancelar.viagem')}}",
            //dados dos formulario, nao obrigatorio(depende do caso)
            data: {'id':id},
            //caso de certo, oq faz
            //parametro 'e' faz referencia ao retorno na pagina citada na url
            success: function (e) {
                if(e == 1){
                    //caso viagem cancelada com sucesso, redirecionamos para uma rotina de viagens
                    window.location.href = "{{route('user.rotina.viagem')}}";
                }else{
                    window.location.reload();
                }
            },
            complete: function(e){
              $("#img-cancelar").css('display','none');
            },
            error: function () {
                alert("Erro ajax");
            }
        });
    });
</script>
</body>
</html>
