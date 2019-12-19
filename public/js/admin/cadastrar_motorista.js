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
$(function(){
    //colca mascara no unico input com id cpf
    $("input#cpf").mask("000.000.000-00", {reverse:true, placeholder:'000.000.000-00'});
    //verfica na digitação do cpf se o mesmo é valido
    $("input#cpf").keyup(function(event) {
        let cpf = $(this).val();
        let valido = validarCPF(cpf);
        if(valido){
            $("#cpf-msg").html("CPF valido!");
        }else if(!valido){
            $("#cpf-msg").html("CPF invalido!");
        }if(cpf == ""){
            $("#cpf-msg").html("CPF é obrigatorio para o motorista!");
        }
    });
    //fim validação cpf ao digitar

    //redireciona o click para input com atributo hidden tipo file com id arquivo
    $("#btn-up").click(function() {
        var file = $(this).parents().find("#arquivo");
        file.trigger("click");
    });

    //pega img e exibe na view
    //seleciona o input file de id arquivo
    $('input#arquivo').change(function(e) {
        var fileName = e.target.files[0].name;
        //seleciona o input texto, que é o falso file
        $("#file-texto").val(fileName);
        var reader = new FileReader();
        reader.onload = function(e) {
            //seleciona a div com img com id preview e atribui a img
            document.getElementById("preview").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });
    //fim do preview da foto
});
