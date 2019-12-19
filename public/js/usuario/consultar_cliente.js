//
$(function(){
//esconde o formulario de filtro ao carregar a pagina
    $("div#form-filtro").hide();
    //mostra o formulario de filtros ao clicar no h2
    $("div#form-filtro-controle h2").click(function(e) {
        $("div#form-filtro").slideToggle('slow');
    });
});
