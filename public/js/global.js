//tempo da msg retorno do servidor php
setTimeout(function(){
    $("div#msg-php").fadeOut('slow');
},tempo_msg);

$(function(){
    //atribu curso pointer nas msg php
    $("div#msg-php").css('cursor', 'pointer');
    //desabilita msg-php ao clicar
    $("div#msg-php").click(function(e) {
        $(this).fadeOut('slow');
    });
});

//tranforma menu bootstrap em multileve
$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
    if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
    }
    let $subMenu = $(this).next('.dropdown-menu');
    $subMenu.toggleClass('show');

    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
        $('.dropdown-submenu .show').removeClass('show');
    });
    return false;
});


//validação bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
        var forms = document.getElementsByClassName('needs-validation');
        // Faz um loop neles e evita o envio
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
