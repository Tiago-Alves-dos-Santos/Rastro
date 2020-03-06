//função de validação de cpf
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');
    if(cpf == '') return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

//
$(function(){
    //colca mascara no unico input com id cpf
    $("input#cpf").mask("000.000.000-00", {reverse:true, placeholder:'000.000.000-00'});
    //verfica na digitação do cpf se o mesmo é valido
    $("input#cpf").keyup(function(e) {
        let cpf = $(this).val();
        let valido = validarCPF(cpf);
        if(valido){
            $("#cpf-msg").html("CPF valido!");
        }else if(!valido){
            $("#cpf-msg").html("CPF invalido!");
        }if(cpf == ""){
            $("#cpf-msg").html("CPF não obrigatorio!");
        }
    });
    //verfica se habilita campo cpf ou passaporte
    $("select#pais").change(function () {
        let valor = $(this).val();
        let cpf = $("#cpf");
        //varivael passaporte abriviada para pass
        let pass = $("#passaporte");
        if (valor == "Brasil") {
            //zera valor do campo passaporte
            $(pass).val("");
            //desabilita campo passaporte
            $(pass).attr({"disabled":""});
            //passaporte nao é mais requerido
            $(pass).removeAttr("required");
            //torna cpf requerido
           // $(cpf).attr({"required":""});
            //habilta campo cpf
            $(cpf).removeAttr("disabled");
        }else{
            //zera valor do campo cpf
            $(cpf).val("");
            //desbilita campo cpf
            $(cpf).attr({"disabled":""});
            //torna cpf inrequerido
            $(cpf).removeAttr("required");
            //torna campo passaprote requerido
          //  $(pass).attr({"required":""});
            //torna campo passaporte habiliatado
            $(pass).removeAttr("disabled");
        }
    });
});
