//esconde formulario de filtro ao carregar a pagina
$(function(){
    $("div#form-filtro").hide();
    //exibe o formulario de filtro ao clicar no h2
    $("div#form-filtro-controle h2").click(function(e) {
        $("div#form-filtro").slideToggle('slow');
    });
});



