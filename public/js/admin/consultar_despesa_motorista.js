//esconde formulario de filtro ao carregar a pagina
$(function(){
    $("div#form-filtro").hide();
    //exibe o formulario de filtro ao clicar no h2
    $("div#form-filtro-controle h2").click(function(e) {
        $("div#form-filtro").slideToggle('slow');
    });

    //pega valor do id despesa armazenado no botao excluir despesa para abrir um modal
    //e colocalo como campo oculto para ser enviado em um post
    $("a#btn_excluir_despesa").click(function (e) {
        //tira o evento padrao do link
        e.preventDefault();
        let id_despesa = $(this).attr("data-id-despesa");
        //seleciona campo oculto(id_despesa) pelo id e seta o valor do id
        $("input#inp_id_despesa").val(id_despesa);
        //adiciona o id despesa junto ao titulo
        $("#exampleModalLabel").html("Exclusão da despesa "+id_despesa);
        //abre o modal
        $("#excluirDespesa").modal('show');
    })
    //atribuindo post do formulario de exclusao de despesa, no botao excluir do modal
    $("#confirma_exclusao_despesa").click(function (e) {
        $("form#form-delete-despesa").trigger("submit");
    })
});
