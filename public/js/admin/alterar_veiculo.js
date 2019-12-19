$(function(){
    //obrigar usuario ligar o caps lock para digitar no campo placa
    $(document).keydown(function (e) {
        //verifca se CapsLock esta ligado retorna true para ativo
        //false para inativo
        var capsLock = event.getModifierState && event.getModifierState('CapsLock');
        if (capsLock) {
            //true == capsLock ligado
            $("span#casp-lock").html("CapsLock ligado!");
            $("span#casp-lock").css('color', 'green');
        }else{
            //false == capsLock desligado
            $("span#casp-lock").html("");
            $("span#casp-lock").css('color', 'red');
        }
    });
    //redireciona o click para input hidden tipo file com id arquivo
    $("#btn-up").click(function() {
        var file = $(this).parents().find("#arquivo");
        file.trigger("click");
    });
    //pega img e exibe na view
    //seleciona o input file de id arquivo
    $('input#arquivo').change(function(e) {
        var fileName = e.target.files[0].name;
        //seleciona o input texto
        $("#file-texto").val(fileName);

        var reader = new FileReader();
        reader.onload = function(e) {
            // seleciona a div com img com id preview e atribui a img
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
});
