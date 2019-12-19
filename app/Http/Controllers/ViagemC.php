<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models;
//classes
use App\Classes;
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
        $viagem->setDataInicio($req->dinicio);
        $viagem->setHorarioSaida($req->hinicio);
        $viagem->setObservacoes($req->observacoes);
        //verfica se preco esta no formato correto
        if($viagem->getPreco() <= 0){
//            echo "O preço informado ".$viagem->getPreco()." esta com formato incorreto!";
            return response()->json("O preço informado ".$viagem->getPreco()." esta com formato incorreto!");
        }
        //instancia do objeto fornecedor
        $fornecedor = new Classes\FornecedorCL();
        $fornecedor->setEmail($req->fornecedor);
        if(!$fornecedor->verficarExistenciaEmail()){
//            echo "O email '".$fornecedor->getEmail()."' do fornecedor não foi encontrado no banco!";
            return response()->json("O email '".$fornecedor->getEmail()."' do fornecedor não foi encontrado no banco!");
        }
        //descobri id do forncedor
        $forncedor_model = $fornecedor->getObjetcColVal('email',$fornecedor->getEmail());
        $fornecedor->setIdFornecedor($forncedor_model->id_fornecedor);
        //viagem com forncedor setado e configurado para cadastro
        $viagem->setFornecedorCl($fornecedor);
        //instancia do objeto cliente e cliente_viagem
        $cliente = new Classes\ClienteCL();
        $cliente_viagem = new Classes\ClienteViagemCL();
        $cliente->setTelefone($req->telefone);
        if(!$cliente->verficarExistenciaTelefone()){
//            echo "O telefone do cliente ".$cliente->getTelefone().", não existe no banco";
            return response()->json("O telefone do cliente ".$cliente->getTelefone().", não existe no banco");
        }
        //descobrir id do cliente
        $cliente_model = $cliente->getObjetcColVal('telefone',$cliente->getTelefone());
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
                return response()->json("O nome ".$motorista->getNome()." colocado em motorista não existe no banco!");
            }
        }
        $ids_motorista = [];
        for($i=0; $i< count($nome_motorista);$i++){
            $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
            //buscar disponibilidade do motorista pelo dia
            $ids_motorista[] = $motorista_model->id_motorista;
            $data_brasil = (string) $viagem->getDataInicio();
            $data_brasil = date('d/m/Y',strtotime($data_brasil));
            if ($viagem->motoristasDisponiveis($ids_motorista) == false){
//                echo "O motorista ".$motorista_model->nome." esta indisponivel para data ".$data_brasil."! Excute a tarfa rotina de viagens e tente novamente";
                return response()->json("O motorista ".$motorista_model->nome." não esta disponivel para data ".$data_brasil."! Excute a tarfa rotina de viagens e tente novamente");
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
                return response()->json("A placa ".$veiculo->getPlaca()." não é existente no banco!");
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


//        //aplicação da regra de negocio, para agendamento de viagem
//        //ids_motoristas[],ids_veiculos[],$placas[]
//        //verificar data agendada
        $data_atual = date("Y/m/d");
        $data_agendada_br = date("d/m/Y", strtotime($viagem->getDataInicio()));
        if (strtotime($data_atual) > strtotime($viagem->getDataInicio())){
//            echo "Atenção a data de agendamento nao possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br;
            return response()->json("Atenção a data de agendamento nao possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br);
        }else if(strtotime($data_atual) == strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Em andamento");
        }else if(strtotime($data_atual) < strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Agendada");
        }
        //verficar se foram colocados motorista ou veiculos repetidos para um mesmo dia

//        cadastrar viagem(verficar se possue status, cadastrar os arrays de ids e placas) e nao esqqueceer de alterar
//         a disponibilidade de veiculo e motorista
        $grupo_veiculo = array_count_values($ids_veiculos);
        $grupo_motorista = array_count_values($ids_motorista);
        foreach ($grupo_motorista as $index => $item) {
            if($item > 1){
                $mt_model = $motorista->getObjetcColVal('id_motorista',$index);
//                echo "O motorista ".$mt_model->nome." esta sendo repetido ".$item." vezes";
                return response()->json("O motorista ".$mt_model->nome." esta sendo repetido ".$item." vezes");
            }
        }

        foreach ($grupo_veiculo as $index => $item) {
            if($item > 1){
                $vc_model = $veiculo->getObjetcColVal('id_veiculo',$index);
                return response()->json("O veiculo ".$vc_model->placa." esta sendo repetido ".$item." vezes");
            }
        }
        $id_viagem = $viagem->agendar();
        $viagem->setIdViagem($id_viagem);
        $motorista_viagem = new Classes\MotoristaVViagemCL();
        $motorista_viagem->setViagemCl($viagem);
        $motorista_viagem->cadastrar($ids_veiculos,$ids_motorista,$placas);
        $cliente_viagem->setViagemCl($viagem);
        $cliente_viagem->cadastrar();
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
        //agendamento concluido com sucesso
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
        $viagem->setDataInicio($req->dinicio);
        $viagem->setHorarioSaida($req->hinicio);
        $viagem->setObservacoes($req->observacoes);
        //verfica se preco esta no formato correto
        if($viagem->getPreco() <= 0){
//            echo "O preço informado ".$viagem->getPreco()." esta com formato incorreto!";
            return response()->json("O preço informado ".$viagem->getPreco()." esta com formato incorreto!");
        }
        //instancia do objeto fornecedor
        $fornecedor = new Classes\FornecedorCL();
        $fornecedor->setEmail($req->fornecedor);
        if(!$fornecedor->verficarExistenciaEmail()){
//            echo "O email '".$fornecedor->getEmail()."' do fornecedor não foi encontrado no banco!";
            return response()->json("O email '".$fornecedor->getEmail()."' do fornecedor não foi encontrado no banco!");
        }
        //descobri id do forncedor
        $forncedor_model = $fornecedor->getObjetcColVal('email',$fornecedor->getEmail());
        $fornecedor->setIdFornecedor($forncedor_model->id_fornecedor);
        //viagem com forncedor setado e configurado para cadastro
        $viagem->setFornecedorCl($fornecedor);
        //instancia do objeto cliente e cliente_viagem
        $cliente = new Classes\ClienteCL();
        $cliente_viagem = new Classes\ClienteViagemCL();
        $cliente->setTelefone($req->telefone);
        if(!$cliente->verficarExistenciaTelefone()){
//            echo "O telefone do cliente ".$cliente->getTelefone().", não existe no banco";
            return response()->json("O telefone do cliente ".$cliente->getTelefone().", não existe no banco");
        }
        //descobrir id do cliente
        $cliente_model = $cliente->getObjetcColVal('telefone',$cliente->getTelefone());
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
                return response()->json("O nome ".$motorista->getNome()." colocado em motorista não existe no banco!");
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
                return response()->json("A placa ".$veiculo->getPlaca()." não é existente no banco!");
            }
        }
        //se o dia digitado diferente do antigo nao precisa verficar se os motoristas atuais sao iguais aos do passado
        if (strtotime($viagem->getDataInicio()) == strtotime($req->data_passado)){
            //se o dia for igual ao antigo precisa verficar motoristas
            $motoristas_atuais = $req->nome_mot;
            $veiculos_atuais = $req->veiculos;

            $motoristas_passado = $req->motorista_passado;
            $veiculos_passado = $req->veiculo_passado;

            $existentes_motorista = [];
            $existentes_veiculos = [];


            for($i=0;$i<count($motoristas_passado);$i++){
                for($j=0;$j<count($motoristas_atuais);$j++){
                    if($motoristas_passado[$i] == $motoristas_atuais[$j]){
                        $existentes_motorista[] = $motoristas_passado[$i];
                    }
                    if($veiculos_passado[$i] == $veiculos_atuais[$j]){
                        $existentes_veiculos[] = $veiculos_passado[$i];
                    }
                }
            }

//            dd($existentes_motorista);
////            return;
            //ignorar ver disponibilidade dos existentes
            $chaves_ignorar_motorista = [];
            $chaves_ignorar_veiculo = [];
            for($i=0; $i< count($existentes_motorista);$i++){
                $chaves_ignorar_motorista[] = array_search($existentes_motorista[$i],$nome_motorista);
            }

            for($i=0; $i< count($existentes_veiculos);$i++){
                $chaves_ignorar_veiculo[] = array_search($existentes_veiculos[$i],$placas);
            }

            $ids_motorista = [];
            for($i=0; $i< count($nome_motorista);$i++){
                //se a chave existeir f
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
                //depois de verficar um por um junta todos
                $ids_motorista = [];
                for($i=0;$i<count($nome_motorista);$i++){
                    $motorista_model = $motorista->getObjetcColVal('nome',$nome_motorista[$i]);
                    $ids_motorista[] = $motorista_model->id_motorista;
                }


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

        $data_atual = date("Y/m/d");
        $data_agendada_br = date("d/m/Y", strtotime($viagem->getDataInicio()));
        if (strtotime($data_atual) > strtotime($viagem->getDataInicio())){
//            echo "Atenção a data de agendamento nao possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br;
            return response()->json("Atenção a data de agendamento nao possui logica, viagem sendo agendada para o passado, data atual: ".date('d/m/Y')." data agendada ".$data_agendada_br);
        }else if(strtotime($data_atual) == strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Em andamento");
        }else if(strtotime($data_atual) < strtotime($viagem->getDataInicio())){
            $viagem->setStatusViagem("Agendada");
        }
        //verficar se foram colocados motorista ou veiculos repetidos para um mesmo dia

//        cadastrar viagem(verficar se possue status, cadastrar os arrays de ids e placas) e nao esqqueceer de alterar
//         a disponibilidade de veiculo e motorista
        $grupo_veiculo = array_count_values($ids_veiculos);
        $grupo_motorista = array_count_values($ids_motorista);
        foreach ($grupo_motorista as $index => $item) {
            if($item > 1){
                $mt_model = $motorista->getObjetcColVal('id_motorista',$index);
//                echo "O motorista ".$mt_model->nome." esta sendo repetido ".$item." vezes";
                return response()->json("O motorista ".$mt_model->nome." esta sendo repetido ".$item." vezes");
            }
        }

        foreach ($grupo_veiculo as $index => $item) {
            if($item > 1){
                $vc_model = $veiculo->getObjetcColVal('id_veiculo',$index);
//                echo "O veiculo ".$vc_model->palca." esta sendo repetido ".$item." vezes";
                return response()->json("O veiculo ".$vc_model->placa." esta sendo repetido ".$item." vezes");
            }
        }
        //mudar para alteração
        $viagem->alterar();
        $motorista_viagem = new Classes\MotoristaVViagemCL();
        $motorista_viagem->setViagemCl($viagem);
        $motorista_viagem->alterar($ids_veiculos,$ids_motorista,$placas);
        $cliente_viagem->setViagemCl($viagem);
        $cliente_viagem->alterar();

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
        //agendamento concluido com sucesso
        return response()->json(1);

    }

    public function viewViagemUnica($id){
        $viagem = new Classes\ViagemCL();
        $viagem->setIdViagem($id);
        $viagem_model = $viagem->consultarViagem();
        $viagem_unica = $viagem->unicoRegistro();
        if($viagem_unica->status_viagem == "Cancelada"){
            session(['msg' => "Impossivel ver mais detalhes de uma viagem cancelada!"]);
            return redirect()->route("read.viagem");
        }
        if(session("tipo_usuario") == "usuario"){
            $viagem_unica->preco = "Sem permissão!";
        }
        $viagem_unica->data_inicio = date('d/m/Y',strtotime($viagem_unica->data_inicio));

        return view('admin.viagem_unica', compact('viagem_unica','viagem_model'));
    }
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

    public function cancelar(Request $req)
    {
        Models\Viagem::where('id_viagem',$req->id)->update([
            "status_viagem" => "Cancelada"
        ]);

        return response()->json(1);
    }

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
        if(session('tipo_usario') == "administrador"){
            $viagem_model = $viagem->filtrar(1,true,$cliente,$motorista);
        }else{
            if(strtotime($req->date_min) < strtotime(date('Y/m/d')))
                $req->date_min = date('Y/m/d');
                $viagem->setDataInicio($req->date_min);
            $viagem_model = $viagem->filtrar(1,false,$cliente,$motorista);
        }

        foreach ($viagem_model as $vg){
            $vg->data_inicio = date('d/m/Y',strtotime($vg->data_inicio));
            if(session("tipo_usuario") == "usuario"){
                $vg->preco = "Sem permissão!";
            }
        }

        return view('admin.consultar_viagem',compact('viagem_model','filtro'));
    }

}
