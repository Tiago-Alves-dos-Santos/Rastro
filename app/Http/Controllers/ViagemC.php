<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models;
//classes
use App\Classes;
use PDF;
class ViagemC extends Controller
{
    public function agendar(Request $req){
        //instancia do objeto viagem
        $viagem = new Classes\ViagemCL();
        $viagem->setOrigem($req->origem);
        $viagem->setDestino($req->destino);
        $viagem->setLocalOrigem($req->lorigem);
        $viagem->setLocalDestino($req->ldestino);
        $viagem->setPreco((float)$req->preco);
        $viagem->setValorMotorista((float) $req->valor_motorista);
        $viagem->setDataInicio($req->dinicio);
        $viagem->setHorarioSaida($req->hinicio);
        $viagem->setObservacoes($req->observacoes);
        //verfica se preco esta no formato correto
        if($viagem->getPreco() <= 0){
            return response()->json("O preço informado ".$viagem->getPreco()." esta com valor incorreto!");
        }
        //verfica se preco esta no formato correto
        if($viagem->getValorMotorista() <= 0){
            return response()->json("O valor da diária informado ".$viagem->getValorMotorista()." esta com valor incorreto!");
        }
        //instancia do objeto fornecedor
        $fornecedor = new Classes\FornecedorCL();
        $fornecedor->setNome($req->fornecedor);
        if(!$fornecedor->verficarNome()){
            return response()->json("O nome '".$fornecedor->getNome()."' do fornecedor não foi encontrado no banco!");
        }
        //descobre o id do forncedor
        $forncedor_model = $fornecedor->getObjetcColVal('nome',$fornecedor->getNome());
        $fornecedor->setIdFornecedor($forncedor_model->id_fornecedor);
        //viagem com forncedor setado e configurado para cadastro
        $viagem->setFornecedorCl($fornecedor);
        //instancia do objeto cliente e cliente_viagem
        $cliente = new Classes\ClienteCL();
        $cliente_viagem = new Classes\ClienteViagemCL();
        //o name do campo é telefone, para desenvovedores , mas recebe o nome pois ta assim
        #para os usaurios
        $cliente->setNome($req->telefone);
        if(!$cliente->verficarNome()){
            return response()->json("O cliente ".$cliente->getNome().", não existe no banco");
        }
        //descobrir id do cliente
        $cliente_model = $cliente->getObjetcColVal('nome',$cliente->getNome());
        $cliente->setIdCliente($cliente_model->id_cliente);
        //setar quantidade de dependentes e cliente ja configurado para cadaastro
        $cliente_viagem->setQuantidade($req->dependente_quantidade);
        $cliente_viagem->setClienteCl($cliente);
        //instancia do objeto motorista
        $motorista = new Classes\MotoristaCL();
        //$req->nome_mot é um array de nomes de motorista
        $nome_motorista = $req->nome_mot;
        for($i=0; $i< count($nome_motorista);$i++){
            $motorista->setNome($nome_motorista[$i]);
            //verfica se nome colocado existe
            if ($motorista->verficarNome() == false){
                return response()->json("O motorista ".$motorista->getNome()." não esta cadastrado!");
            }
        }
        //inicia um array para armazenas os ids dos motoristas solicitados na viagem
        $ids_motorista = [];
        for($i=0; $i< count($nome_motorista);$i++){
            //retorna um objeto pelo nome, o cliente quis assim mesmo sabendo que o nome nao era um campo confiavel
            //para fazer isso
            $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
            //buscar disponibilidade do motorista pelo dia
            $ids_motorista[] = $motorista_model->id_motorista;
            $data_brasil = (string) $viagem->getDataInicio();
            $data_brasil = date('d/m/Y',strtotime($data_brasil));
            //verfica os motoristas disponiveis na data colocada
            if ($viagem->motoristasDisponiveis($ids_motorista) == false){
                return response()->json("O motorista ".$motorista_model->nome." não esta disponivel para data ".$data_brasil."! Excute a tarefa rotina de viagens e tente novamente");
            }

        }
        //instancia do objeto veiculo
        $veiculo = new Classes\VeiculoCL();
        //$req->veiculos é um array de placas de veiculos
        $placas = $req->veiculos;
        for ($i=0; $i < count($placas); $i++){
            $veiculo->setPlaca($placas[$i]);
            if ($veiculo->verficarExistencia() == false){
//                echo "A placa ".$veiculo->getPlaca()." não é existente no banco";
                return response()->json("O veículo ".$veiculo->getPlaca()." não esta cadastrado");
            }
        }
        //inicia um array com ids do veiculos solicitados
        $ids_veiculos = [];
        for ($i=0; $i < count($placas); $i++){
            $veiculo_model = $veiculo->getObjetcColVal('placa',$placas[$i]);
            //buscar disponibilidade do veiculo pelo dia
            $ids_veiculos[] = $veiculo_model->id_veiculo;
            if ($viagem->veiculosDisponiveis($ids_veiculos) == false){
                $data_brasil = (string) $viagem->getDataInicio();
                $data_brasil = date('d/m/Y',strtotime($data_brasil));
                return response()->json("O veiculo ".$veiculo_model->placa." não esta disponivel para a data ".$data_brasil."! Verfique os veiculos disponiveis e tente novamente!");
            }

        }

//        //verificar data agendada
        $data_atual = date("Y/m/d");
        $data_agendada_br = date("d/m/Y", strtotime($viagem->getDataInicio()));
        //se a viagem for uma viagem com data antiga, nao verfica os motoristas e veiculos
        $viagem_antiga = false;
        //se a data atual for no futuro da data agendada, nao realiza um agendamento
        if (strtotime($data_atual) > strtotime($viagem->getDataInicio())){
            //habilite e desabilite viagens passadas
//            return response()->json("Atenção a data de agendamento não possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br);
            $viagem->setStatusViagem("Concluida");
            $viagem_antiga = true;
        }else if(strtotime($data_atual) == strtotime($viagem->getDataInicio())){
            //caso a data atual seja igual a data agendada viagem fica em andamento
            $viagem->setStatusViagem("Em andamento");
        }else if(strtotime($data_atual) < strtotime($viagem->getDataInicio())){
            //caso data atual for no passado da data agendada, viagem fica agendada para o futuro
            $viagem->setStatusViagem("Agendada");
        }
        //verfica se foram colocados veiculos e motorista mais de uma vez para uma unica viagem
        $grupo_veiculo = array_count_values($ids_veiculos);
        $grupo_motorista = array_count_values($ids_motorista);
        foreach ($grupo_motorista as $index => $item) {
            if($item > 1){
                $mt_model = $motorista->getObjetcColVal('id_motorista',$index);
//                echo "O motorista ".$mt_model->nome." esta sendo repetido ".$item." vezes";
                return response()->json("O motorista ".$mt_model->nome." esta repetido ".$item." vezes");
            }
        }

        foreach ($grupo_veiculo as $index => $item) {
            if($item > 1){
                $vc_model = $veiculo->getObjetcColVal('id_veiculo',$index);
                return response()->json("O veiculo ".$vc_model->placa." esta repetido ".$item." vezes");
            }
        }
        //caso tudo certo realiza o agendamento
        $id_viagem = $viagem->agendar();
        $viagem->setIdViagem($id_viagem);
        $motorista_viagem = new Classes\MotoristaVViagemCL();
        $motorista_viagem->setViagemCl($viagem);
        $motorista_viagem->cadastrar($ids_veiculos,$ids_motorista,$placas);
        $cliente_viagem->setViagemCl($viagem);
        $cliente_viagem->cadastrar();

        if($viagem_antiga){
            //agendamento concluido com sucesso, retorna 1, sem mudar status de motoristas e carros
            return response()->json(1);
        }
        //apos realizar os agendamentos nas tabelas altera-se os status de motoristas e veiculos
        //atualizar status de motorista e veicculo
        foreach ($ids_veiculos as $id){
            Models\Veiculo::where('id_veiculo',$id)->update([
                "disponivel" => $viagem->getStatusViagem()
            ]);
        }

        foreach ($ids_motorista as $id){
            Models\Motorista::where('id_motorista',$id)->update([
                "status_motorista" => $viagem->getStatusViagem()
            ]);
        }
        //agendamento concluido com sucesso, retorna 1
        return response()->json(1);
    }


    public function alterar(Request $req){
        //instancia do objeto viagem
        $viagem = new Classes\ViagemCL();
        $viagem->setIdViagem((int)$req->id_viagem);
        $viagem->setOrigem($req->origem);
        $viagem->setDestino($req->destino);
        $viagem->setLocalOrigem($req->lorigem);
        $viagem->setLocalDestino($req->ldestino);
        $viagem->setPreco((float)$req->preco);
        $viagem->setValorMotorista((float) $req->valor_motorista);
        $viagem->setDataInicio($req->dinicio);
        $viagem->setHorarioSaida($req->hinicio);
        $viagem->setObservacoes($req->observacoes);
        //verfica se preco esta no formato correto
        if($viagem->getPreco() <= 0){
//            echo "O preço informado ".$viagem->getPreco()." esta com formato incorreto!";
            return response()->json("O preço informado ".$viagem->getPreco()." esta com valor incorreto!");
        }
        if($viagem->getValorMotorista() <= 0){
//            echo "O preço informado ".$viagem->getPreco()." esta com formato incorreto!";
            return response()->json("O valor da diária informado ".$viagem->getPreco()." esta com valor incorreto!");
        }
        //instancia do objeto fornecedor
        $fornecedor = new Classes\FornecedorCL();
        $fornecedor->setNome($req->fornecedor);
        if(!$fornecedor->verficarNome()){
            return response()->json("O nome '".$fornecedor->getNome()."' do fornecedor não foi encontrado no banco!");
        }
        //descobri id do forncedor
        $forncedor_model = $fornecedor->getObjetcColVal('nome',$fornecedor->getNome());
        $fornecedor->setIdFornecedor($forncedor_model->id_fornecedor);
        //viagem com forncedor setado e configurado para cadastro
        $viagem->setFornecedorCl($fornecedor);
        //instancia do objeto cliente e cliente_viagem
        $cliente = new Classes\ClienteCL();
        $cliente_viagem = new Classes\ClienteViagemCL();
        # esta com name telfone para prgamdores e o nome 'nome' para usuarios 
        $cliente->setNome($req->telefone);
        if(!$cliente->verficarNome()){
            return response()->json("O cliente ".$cliente->getNome().", não existe no banco");
        }
        //descobrir id do cliente
        $cliente_model = $cliente->getObjetcColVal('nome',$cliente->getNome());
        $cliente->setIdCliente($cliente_model->id_cliente);
        //setar quantidade de dependentes e cliente ja configurado para cadaastro
        $cliente_viagem->setQuantidade($req->dependente_quantidade);
        $cliente_viagem->setClienteCl($cliente);
        //instancia do objeto motorista
        $motorista = new Classes\MotoristaCL();
        //$req->nome_mot é um array de nomes de motorista
        $nome_motorista = $req->nome_mot;
        for($i=0; $i< count($nome_motorista);$i++){
            $motorista->setNome($nome_motorista[$i]);
            if ($motorista->verficarNome() == false){
//                echo "O nome ".$motorista->getNome()." colocado em motorista não existe no banco!";
                return response()->json("O motorista ".$motorista->getNome()." não é cadastrado!");
            }
        }

        //instancia do objeto veiculo
        $veiculo = new Classes\VeiculoCL();
        //$req->veiculos é um array de placas de veiculos
        $placas = $req->veiculos;
        for ($i=0; $i < count($placas); $i++){
            $veiculo->setPlaca($placas[$i]);
            if ($veiculo->verficarExistencia() == false){
//                echo "A placa ".$veiculo->getPlaca()." não é existente no banco";
                return response()->json("O veículo ".$veiculo->getPlaca()." não é cadastrado!");
            }
        }
        //se o dia digitado for diferente do antigo nao precisa verficar
        //  se os motoristas e veiculos atuais sao iguais aos do passado
        if (strtotime($viagem->getDataInicio()) == strtotime($req->data_passado)){
            //se o dia for igual ao antigo precisa verficar motoristas

            //recebe-se um array de motoristas e veiculos atuais
            $motoristas_atuais = $req->nome_mot;
            $veiculos_atuais = $req->veiculos;
            //recebe-se um array de motoristas e veiculos do pasasdo
            $motoristas_passado = $req->motorista_passado;
            $veiculos_passado = $req->veiculo_passado;
            //array q vao armazena veiculos do passado existentes nos motoristas atuais
            $existentes_motorista = [];
            $existentes_veiculos = [];

            //percorremos o os motoristas do passado
            for($i=0;$i<count($motoristas_passado);$i++){
                //percorremos os motoristas atuais
                for($j=0;$j<count($motoristas_atuais);$j++){
                    //se o motorista do passado for igual a motorista atual, entao o motorista
                    //do passado é existente no motorista atual
                    if($motoristas_passado[$i] == $motoristas_atuais[$j]){
                        $existentes_motorista[] = $motoristas_passado[$i];
                    }
                    //como os arrays tem o mesmo tamanho, ja que um motorista esta para um veiculo
                    //enato verfico a mesma logica para os veiculos
                    if($veiculos_passado[$i] == $veiculos_atuais[$j]){
                        $existentes_veiculos[] = $veiculos_passado[$i];
                    }
                }
            }
            //um array que vai armazenas chaves dos motoristas existentes
            $chaves_ignorar_motorista = [];
            $chaves_ignorar_veiculo = [];
            //precorremos motoristas existentes
            for($i=0; $i< count($existentes_motorista);$i++){
                //vai procurar os motoristas existentes no array de nomes dos motoristas atuais
                //caso ele exista vamos pegar a ey referente ao valor do nome do array nome_motorista
                $chaves_ignorar_motorista[] = array_search($existentes_motorista[$i],$nome_motorista);
            }

            for($i=0; $i< count($existentes_veiculos);$i++){
                //a mesma logica para os veiculos
                $chaves_ignorar_veiculo[] = array_search($existentes_veiculos[$i],$placas);
            }
            //inicia um array para armazena os ids dos motoritas
            $ids_motorista = [];
            //pecorremos o array de nomes motoristas
            for($i=0; $i< count($nome_motorista);$i++){
                //como temos a chaves para ignorar, qnd i for igual chave a ignorar ele nao vai executar
                //o algortimo
                if(!in_array($i, $chaves_ignorar_motorista)){
                    $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
                    //buscar disponibilidade do motorista pelo dia
                    $ids_motorista[] = $motorista_model->id_motorista;
                    $data_brasil = (string) $viagem->getDataInicio();
                    $data_brasil = date('d/m/Y',strtotime($data_brasil));
                    if ($viagem->motoristasDisponiveis($ids_motorista) == false){
                        return response()->json("O motorista ".$motorista_model->nome." não esta disponivel para data ".$data_brasil."! Excute a tarefa rotina de viagens e tente novamente");
                    }
                }
                //depois de verificar as disponibilidades do motoristas novos, ja que ignoramos os existentes do
                // passado pois ja sabemos que eles estao disponiveis para o dia, ja que a existiam antes
                $ids_motorista = [];
                //pecorremos novamente o array de nomes, dessa vez pegando o id de todos existentes e novos
                for($i=0;$i<count($nome_motorista);$i++){
                    $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
                    $ids_motorista[] = $motorista_model->id_motorista;
                }

                //alogica se repete para os veiculos
                $ids_veiculos = [];
                for ($i=0; $i < count($placas); $i++){
                    if(!in_array($i,$chaves_ignorar_veiculo)){
                        $veiculo_model = $veiculo->getObjetcColVal('placa',$placas[$i]);
                        //buscar disponibilidade do veiculo pelo dia
                        $ids_veiculos[] = $veiculo_model->id_veiculo;
                        $data_brasil = (string) $viagem->getDataInicio();
                        $data_brasil = date('d/m/Y',strtotime($data_brasil));
                        if ($viagem->veiculosDisponiveis($ids_veiculos) == false){
                            return response()->json("O veiculo ".$veiculo_model->placa." não esta disponivel para a data ".$data_brasil."! Verfique os veiculos disponiveis e tente novamente!");
                        }
                    }
                }

                //juntar id com motoristas q nao foram verficados
                $ids_veiculos = [];
                for($i=0;$i<count($placas);$i++){
                    $veiculo_model = $veiculo->getObjetcColVal('placa',$placas[$i]);
                    //buscar disponibilidade do veiculo pelo dia
                    $ids_veiculos[] = $veiculo_model->id_veiculo;
                }

            }
        }else{
            //caso o dia seja alterado, ira ser realizado como se fosse um cadastro novamente, ja que vamos ter
            //que verficar motoristas novos e antigos
            $ids_motorista = [];
            for($i=0; $i< count($nome_motorista);$i++){
                $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
                //buscar disponibilidade do motorista pelo dia
                $ids_motorista[] = $motorista_model->id_motorista;
                $data_brasil = (string) $viagem->getDataInicio();
                $data_brasil = date('d/m/Y',strtotime($data_brasil));
                if ($viagem->motoristasDisponiveis($ids_motorista) == false){
//                echo "O motorista ".$motorista_model->nome." esta indisponivel para data ".$data_brasil."! Excute a tarfa rotina de viagens e tente novamente";
                    return response()->json("O motorista ".$motorista_model->nome." esta indisponivel para data ".$data_brasil."! Excute a tarfa rotina de viagens e tente novamente");
                }

            }

            $ids_veiculos = [];
            for ($i=0; $i < count($placas); $i++){
                $veiculo_model = $veiculo->getObjetcColVal('placa',$placas[$i]);
                //buscar disponibilidade do veiculo pelo dia
                $ids_veiculos[] = $veiculo_model->id_veiculo;
                if ($viagem->veiculosDisponiveis($ids_veiculos) == false){
                    $data_brasil = (string) $viagem->getDataInicio();
                    $data_brasil = date('d/m/Y',strtotime($data_brasil));
//                echo "O veiculo ".$veiculo_model->placa." não esta indisponivel para a data ".$data_brasil."! Verfique os veiculos disponiveis e tente novamente!";
                    return response()->json("O veiculo ".$veiculo_model->placa." não esta disponivel para a data ".$data_brasil."! Verfique os veiculos disponiveis e tente novamente!");
                }

            }
        }
        //depois de ter verificado a data veiulos e motoristas novos e antigos, vamos realizar uma alteração normal
        //verificando a data agendada igual no caastro
        $data_atual = date("Y/m/d");
        $data_agendada_br = date("d/m/Y", strtotime($viagem->getDataInicio()));
        //se a viagem for uma viagem com data antiga, nao verfica os motoristas e veiculos
        $viagem_antiga = false;
        if (strtotime($data_atual) > strtotime($viagem->getDataInicio())){
            //habilite e desabilite viagens passadas
//            return response()->json("Atenção a data de agendamento não possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br);
            $viagem->setStatusViagem("Concluida");
            $viagem_antiga = true;
        }else if(strtotime($data_atual) == strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Em andamento");
        }else if(strtotime($data_atual) < strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Agendada");
        }

        //verfica motoristas e veiculos repetidos em uma mesma viagem
        $grupo_veiculo = array_count_values($ids_veiculos);
        $grupo_motorista = array_count_values($ids_motorista);
        foreach ($grupo_motorista as $index => $item) {
            if($item > 1){
                $mt_model = $motorista->getObjetcColVal('id_motorista',$index);
                return response()->json("O motorista ".$mt_model->nome." esta repetido ".$item." vezes");
            }
        }

        foreach ($grupo_veiculo as $index => $item) {
            if($item > 1){
                $vc_model = $veiculo->getObjetcColVal('id_veiculo',$index);
                return response()->json("O veículo ".$vc_model->placa." esta repetido ".$item." vezes");
            }
        }
        //realiza a alteração, em todas tabelas que se relacionam com viagem
        $viagem->alterar();
        $motorista_viagem = new Classes\MotoristaVViagemCL();
        $motorista_viagem->setViagemCl($viagem);
        $motorista_viagem->alterar($ids_veiculos,$ids_motorista,$placas);
        $cliente_viagem->setViagemCl($viagem);
        $cliente_viagem->alterar();
        if($viagem_antiga){
            return response()->json(1);
        }
        //atualizar status de motorista e veicculo
        foreach ($ids_veiculos as $id){
            Models\Veiculo::where('id_veiculo',$id)->update([
                "disponivel" => $viagem->getStatusViagem()
            ]);
        }

        foreach ($ids_motorista as $id){
            Models\Motorista::where('id_motorista',$id)->update([
                "status_motorista" => $viagem->getStatusViagem()
            ]);
        }
        //alteração concluida com sucesso, retorna 1
        return response()->json(1);

    }
    //ver viagem unica, mais detalhes
    public function viewViagemUnica($id){
        $viagem = new Classes\ViagemCL();
        $viagem->setIdViagem($id);
        $viagem_model = $viagem->consultarViagem();
        $viagem_unica = $viagem->unicoRegistro();
        //se viagem for cancelada vc nao podera ver mais detalhes sobre ela
        if($viagem_unica->status_viagem == "Cancelada"){
            session(['msg' => "Impossivel ver mais detalhes de uma viagem cancelada!"]);
            return redirect()->route("read.viagem");
        }
        //se o usuario nao tiver acesso administrador ela nao podera ver o preço
        if(session("tipo_usuario") == "usuario"){
            $viagem_unica->preco = "Sem permissão!";
            $viagem_unica->valor_motorista = "Sem permissão!";
        }
        //formata a data para o usuario
        $viagem_unica->data_inicio = date('d/m/Y',strtotime($viagem_unica->data_inicio));

        return view('admin.viagem_unica', compact('viagem_unica','viagem_model'));
    }
    //usada na pagina consultar viagens(ao clicar no olho), feita por requisao ajax, para ver e desver motoristas
    //de uma determinada viagem
    public function viagemUnica(Request $req){
        $viagem = new Classes\ViagemCL();
        $viagem->setIdViagem($req->id_viagem);
        $viagem_model = $viagem->consultarViagem();
        if ($req->ajax()){
            return response()->json($viagem_model);
        }else{
            return $viagem_model;
        }
    }
    //tarefa diaria para fazer umarotina de viagens, verfica as viagens da mais antiga para mais atual
    //de acordo com dia muda o status da viagem, motoristas e veiculos pertencentes a viagem, ele verfica todas
    //as viagens
    public function rotinaViagens(){
        $viagem = new Classes\ViagemCL();
        $viagens = $viagem->consultarViagensOrderRotina();
        $data_atual = date('Y/m/d');
        foreach ($viagens as $vg){
            if($vg->status_viagem != "Cancelada"){
                $status = "";
                if(strtotime($vg->data_inicio) == strtotime($data_atual)){
                    $status = "Em andamento";
                }else if(strtotime($vg->data_inicio) > strtotime($data_atual)){
                    $status = "Agendada";
                }else if(strtotime($vg->data_inicio) < strtotime($data_atual)){
                    $status = "Concluida";
                }

                Models\Viagem::where('id_viagem',$vg->id_viagem)->update([
                    "status_viagem" => $status
                ]);
                Models\Motorista::where('id_motorista',$vg->id_motorista)->update([
                    "status_motorista" => $status
                ]);
                Models\Veiculo::where('id_veiculo',$vg->id_veiculo)->update([
                    "disponivel" => $status
                ]);
            }
        }
        //redirecionar para consulta de viagens
        session(["msg"=>"Rotina realizada com sucesso"]);
        return redirect()->route("read.viagem");

    }
    //realiza o cancelamento da viagem e retorna para o ajax o sucesso, que depois do sucesso
    //o javascript ajax vai redirecionar para a rotina de viagens, para excluir da visualização, mas nao do banco
    public function cancelar(Request $req)
    {
        Models\Viagem::where('id_viagem',$req->id)->update([
            "status_viagem" => "Cancelada"
        ]);

        return response()->json(1);
    }
    //realiza o filtro das viagens
    public function filtrar(Request $req){
        if(is_null($req->cliente)){
            $req->cliente = "*";
        }
        if(is_null($req->motorista)){
            $req->motorista = "*";
        }
        if(is_null($req->disponibilidade)){
            $req->disponibilidade = "*";
        }
        if(is_null($req->date_max)){
            $req->date_max = "*";
        }
        if(is_null($req->date_min)){
            $req->date_min = "*";
        }
        //verfica se intervalo de datas possui logica
        if($req->date_min != "*" && $req->date_max != "*"){
            if(strtotime($req->date_min) > strtotime($req->date_max)){
                session(['msg' => "Erro no filtro! data minima maior que data maxima!"]);
                return redirect()->route("read.viagem");
            }
        }
        $viagem_model = null;
        $filtro = $req->except(['_token']);
        $cliente = new Classes\ClienteCL();
        $motorista = new Classes\MotoristaCL();
        $viagem = new Classes\ViagemCL();

        $cliente->setNome($req->cliente);
        $motorista->setNome($req->motorista);
        $viagem->setDataInicio($req->date_min);
        $viagem->setDataTermino($req->date_max);
        $viagem->setStatusViagem($req->disponibilidade);
        //retorna o filtro de acordo com o tipo  de usuario
        if(session('tipo_usuario') == "administrador"){
            $viagem_model = $viagem->filtrar(10,true,$cliente,$motorista);
        }else{
            //se nao for administrador a data minima ser buscada tem q ser igual ou maior q a data atual
            //caso ele digite uma data menor do que a data atual, realizamos um conversao
            if(strtotime($req->date_min) < strtotime(date('Y/m/d'))){
                $viagem->setDataInicio(date('Y/m/d'));
                $viagem_model = $viagem->filtrar(10,false,$cliente,$motorista);
            }else{
                //caso data do usuario obedeça a regra nao fazemos uma conversao
                $viagem_model = $viagem->filtrar(10,false,$cliente,$motorista);
            }

        }
        //depois de realizar o filtro convertemos a data para o brasileiro
        foreach ($viagem_model as $vg){
            $vg->data_inicio = date('d/m/Y',strtotime($vg->data_inicio));
            //e invalidamos o preço para os nao administradores
            if(session("tipo_usuario") == "usuario"){
                $vg->preco = "Sem permissão!";
            }
        }

        return view('admin.consultar_viagem',compact('viagem_model','filtro'));
    }
    //criamos um pdf de uma unica viagem,ordem de serviçço
    public function printPdf($id){
        $viagem = new Classes\ViagemCL();
        $viagem->setIdViagem((int) $id);
        $viagem_unica = $viagem->unicoRegistro();
        $viagem_all = $viagem->consultarViagem();
        $viagem_unica->data_inicio = date('d/m/Y',strtotime($viagem_unica->data_inicio));
        $pdf = PDF::loadView('pdf.ordem_servico', compact('viagem_unica','viagem_all'));
        $pdf->setPaper('A4', 'portrait');
//        $pdf->setWarnings(false);
//fim configuraoes
        return $pdf->stream('orderm_de_servico_l'.$id.'.pdf');

    }

}
