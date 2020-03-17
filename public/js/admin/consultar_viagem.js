//esconde formulario de filtro ao carregar a pagina
$(function(){
    $("div#form-filtro").hide();
    //exibe o formulario de filtro ao clicar no h2
    $("div#form-filtro-controle h2").click(function(e) {
        $("div#form-filtro").slideToggle('slow');
    });

    //permitir apenas um categoria de filtro por vez
    /**
     * Classes
     *
     * motorista
     * cliente
     * fornecedor
     * status
     */
    //ao clicar em motorista
    $("input.motorista").click(function (e) {
        for (let i = 0; i < $("input.cliente").length; i++) {
            $("input.cliente").eq(i).val("");
            $("input.fornecedor").eq(i).val("");
            $("select.status").val("");
        }
    })
    //ao clicar em fornecedor
    $("input.fornecedor").click(function (e) {
        for (let i = 0; i < $("input.cliente").length; i++) {
            $("input.cliente").eq(i).val("");
            $("input.motorista").eq(i).val("");
            $("select.status").val("");
        }
    })
    //ao clicar em cliente
    $("input.cliente").click(function (e) {
        for (let i = 0; i < $("input.cliente").length; i++) {
            $("input.fornecedor").eq(i).val("");
            $("input.motorista").eq(i).val("");
            $("select.status").val("");
        }
    })
    //ao mudar valor do sleect
    $("select.status").change(function (e) {
        for (let i = 0; i < $("input.cliente").length; i++) {
            $("input.fornecedor").eq(i).val("");
            $("input.motorista").eq(i).val("");
            $("input.cliente").eq(i).val("");
        }
    })
});



