$(function(){
    var current = 1,current_step,next_step,steps;
    steps = $("fieldset").length;
    $(".next").click(function(){
        current_step = $(this).parents("fieldset");
        next_step = $(this).parents("fieldset").next();
        next_step.show();
        current_step.hide();
        setProgressBar(++current);
    });
    $(".previous").click(function(){
        current_step = $(this).parents("fieldset");
        next_step = $(this).parents("fieldset").prev();
        next_step.show();
        current_step.hide();
        setProgressBar(--current);
    });
    setProgressBar(current);
    // Change progress bar action
    function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width",percent+"%")
            .html((percent-1)+"%");
    }
});

//add cleinte
$(function(){
    $("#btn-add").click(function (e) {
        let motorista = $("#motorista");
        let veiculo = $("#veiculo");
        if ($(veiculo).val() == "" || $(motorista).val() == ""){
            $("#msg-dialog p").html("O campo veiculo ou(e) motorista esta vazio!");
            $("#msg-dialog").attr('title','Campo(s) Nulo(s)');
            $("#msg-dialog").dialog();
        }else{
            //pegar valores dos campos
            let nome = $(motorista).val();
            let placa = $(veiculo).val();
            //pegar ultimo id exisntente da linha
            let linhas = $("table tbody tr");
            let quantidades = $(linhas).length;
            let linha_gerar = 0;
            if(quantidades == null){
                quantidades = 0;

            }else{
                if(quantidades % 2==0){
                    linha_gerar = quantidades + 5;
                }else{
                    linha_gerar = quantidades * 2;
                }
            }


            $("table tbody").append("<tr id='"+linha_gerar+"'>" +
                "<td>" +
                "<input type='text' class='form-control nome_mot' value='"+nome+"' name='nome_mot[]' id='' data-nome='Nome motorista "+linha_gerar+"' readonly>\n" +
                "</td>" +
                "<td>" +
                "<input type='text' class='form-control placa' value='"+placa+"' name='veiculos[]' id='' placeholder='Placa || Indetificação' data-nome='Placa || Indetificação do veiculo "+linha_gerar+"' readonly>" +
                "</td>" +
                "<td>" +
                "<button id='"+linha_gerar+"' type='button' class='btn btn-danger btn-block delete'><i class='fas fa-user-minus'></i></button>" +
                "</td>\n" +
                "</tr>");

            $("button.delete").click(function (e) {
                let id = $(this).attr('id');
                $("table tbody tr#"+id).remove();
            })

        }
    });

    $("button.delete").click(function (e) {
        let id = $(this).attr('id');
        $("table tbody tr#"+id).remove();
    })
});

//colocar cpfs nos campos
$("input.cpf").mask("000.000.000-00",{reverse:true, placeholder:'000.000.000-00'});

//esconder dialog ao carregar a pagina
$("#msg-dialog").hide();


