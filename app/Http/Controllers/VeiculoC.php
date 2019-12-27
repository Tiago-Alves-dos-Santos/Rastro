<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models\Veiculo;
//classes
use App\Classes\VeiculoCL;
class VeiculoC extends Controller
{
    public function cadastrar(Request $req)
    {
    	$veiculo = new VeiculoCL();
    	//seta os valores no objeto veiculo para validação
    	$veiculo->setPlaca(strtoupper($req->placa));
    	$veiculo->setMarca($req->marca);
    	$veiculo->setModelo($req->modelo);
    	$veiculo->setPropietario($req->propietario);
    	$veiculo->setAno((int) $req->ano);
    	$veiculo->setCapacidadeMaxima((int) $req->capacidade);
    	$veiculo->setVinculo($req->vinculo);
        $veiculo->setTipo($req->tipo);
    	//pega o arquivo
    	$arquivo = $_FILES['ft_carro'];
    	//verfica se arquivo possui algum erro
    	$erro = $arquivo['error'];

    	switch ($erro) {
    		case 1:
    			session(["msg"=>"Arquivo de foto atingiu o tamanho máximo no PHP"]);
            	return redirect()->route("create.veiculo");
    			break;

    		case 2:
    			session(["msg"=>"Arquivo atingiu o tamanho máximo no HTML."]);
            	return redirect()->route("create.veiculo");
    			break;
    		case 3:
    			session(["msg"=>"Arquivo foi parcialmente carregado."]);
            	return redirect()->route("create.veiculo");
    			break;
    		case 4:
            //o erro 4 verfica e obriga o arquivo a nao ter valor nulo,
            //descomente o codigo abaixo para usar isso
    			// session(["msg"=>"Erro: arquivo não carregado."]);
       //      	return redirect()->route("create.motorista");
    			break;
    	}
    	//definimos o diretorio de upload
    	$diretorio = "upload/veiculos/";
    	//realiza o cadastro
    	if ($veiculo->verficarExistencia() == false) {
    		$veiculo->cadastrar();
    	}else{
    		session(["msg"=>"O veiculo a ser cadastrado já existe!"]);
            return redirect()->route("create.veiculo");
    	}
        //caso arquivo diferente de nulo, faz um upload de foto
    	if ($arquivo['name'] != "") {
            //pega o id do ultimo veiculo cadastrado
    		$id_veiculo = (int)DB::getPdo()->lastInsertId();
    		$veiculo->setIdVeiculo($id_veiculo);
    		//pego a extensao do arquivo
    		$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    		//atribuo o id como nome da img
    		$arquivo['name'] = (string) $veiculo->getIdVeiculo();
    		//adiciono a extensao ao novo nome
    		$novo_nome = $arquivo['name'].".".$extensao;

    		//verfica se  upload final irar da certo
	    	if (move_uploaded_file($arquivo['tmp_name'], $diretorio . $novo_nome)) {
	    		$diretorio .= $novo_nome;
	    		$veiculo->setFoto($diretorio);
	    		Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->update(["foto_carro"=>$veiculo->getFoto()]);

			}else {
                //caso erro no upload deixa foto padrao
			    session(["msg"=>"Erro ao tentar fazer upload de imagem, atribuimos a foto padrao"]);

                $diretorio .= "foto_padrao.png";
                $veiculo->setFoto($diretorio);
                Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->update(["foto_carro"=>$veiculo->getFoto()]);
            	return redirect()->route("create.veiculo");
			}
    	}else{
            //caso arquivo igual a nulo, coloca foto padrao
    		$diretorio .= "foto_padrao.png";
    		$veiculo->setFoto($diretorio);
    		$id_veiculo = (int)DB::getPdo()->lastInsertId();
    		$veiculo->setIdVeiculo($id_veiculo);
                Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->update(["foto_carro"=>$veiculo->getFoto()]);
    	}
    	session(["msg"=>"Cadastro reliazado com sucesso!"]);
        return redirect()->route("create.veiculo");
    }

    public function alterar(Request $req)
    {
        $veiculo = new VeiculoCL();
        //seta os valores no objeto veiculo para validação
        $veiculo->setIdVeiculo((int)$req->id_veiculo);
        $veiculo->setPlaca(strtoupper($req->placa));
        $veiculo->setMarca($req->marca);
        $veiculo->setModelo($req->modelo);
        $veiculo->setPropietario($req->propietario);
        $veiculo->setAno((int) $req->ano);
        $veiculo->setCapacidadeMaxima((int) $req->capacidade);
        $veiculo->setVinculo($req->vinculo);
        $veiculo->setTipo($req->tipo);
        //pega o arquivo
        $arquivo = $_FILES['ft_carro'];
        //verfica se arquivo possui algum erro
        $erro = $arquivo['error'];

        switch ($erro) {
            case 1:
                session(["msg"=>"Arquivo de foto atingiu o tamanho máximo no PHP"]);
                return redirect()->route('alter.veiculo',['id' => $veiculo->getIdVeiculo()]);
                break;

            case 2:
                session(["msg"=>"Arquivo atingiu o tamanho máximo no HTML."]);
                return redirect()->route('alter.veiculo',['id' => $veiculo->getIdVeiculo()]);
                break;
            case 3:
                session(["msg"=>"Arquivo foi parcialmente carregado."]);
                return redirect()->route('alter.veiculo',['id' => $veiculo->getIdVeiculo()]);
                break;
            case 4:
            //o erro 4 verfica e obriga o arquivo a nao ter valor nulo,
            //descomente o codigo abaixo para usar isso
                // session(["msg"=>"Erro: arquivo não carregado."]);
       //       return redirect()->route("create.motorista");
                break;
        }
        //define o direotrio das fotos
        $diretorio = "upload/veiculos/";

        if ($veiculo->verficarExistenciaAlteracao()) {
            session(["msg"=>"O veiculo a ser cadastrado já existe!"]);
            return redirect()->route('alter.veiculo',['id' => $veiculo->getIdVeiculo()]);
        }else{
            $veiculo->alterar();
        }

        if ($arquivo['name'] != "") {
            $veiculo_alter = Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->first();
            //verfica se é a foto padrao, para nao apagar a mesma
            if ($veiculo_alter->foto_carro != $diretorio."foto_padrao.png") {
                unlink($veiculo_alter->foto_carro);
            }


            //pego a extensao do arquivo
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            //atribuo o id como nome da img
            $arquivo['name'] = (string) $veiculo->getIdVeiculo();
            //adiciono a extensao ao novo nome
            $novo_nome = $arquivo['name'].".".$extensao;
            //defino o diretorio final
            $diretorio_final = $diretorio.$novo_nome;
            //verfica se  upload final irar da certo
            if (move_uploaded_file($arquivo['tmp_name'], $diretorio_final)) {
                $veiculo->setFoto($diretorio_final);
                Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->update(["foto_carro"=>$veiculo->getFoto()]);

            }else {
                //caso de erro no upload coloca foto padrao
                session(["msg"=>"Erro ao tentar fazer upload de imagem, atribuimos a foto padrao"]);
                $diretorio .= "foto_padrao.png";
                $veiculo->setFoto($diretorio);
                Veiculo::where("id_veiculo",$veiculo->getIdVeiculo())->update(["foto_carro"=>$veiculo->getFoto()]);
                return redirect()->route("read.veiculo");
            }
        }
        session(["msg"=>"Alteração realizada com sucesso!"]);
        return redirect()->route("read.veiculo");

    }

    public function filtrar(Request $req){
        if(is_null($req->placa)){
            $req->placa = "%*";
        }
        if(is_null($req->propietario)){
            $req->propietario = "*";
        }
        if(is_null($req->vinculo)){
            $req->vinculo = "*";
        }
        if(is_null($req->disponibilidade)){
            $req->disponibilidade = "*";
        }
        $filtros = $req->except(['_token']);
        $veiculo = new VeiculoCL();
        $veiculo->setPlaca($req->placa);
        $veiculo->setPropietario($req->propietario);
        $veiculo->setVinculo($req->vinculo);
        $veiculo->setDisponivel($req->disponibilidade);
        $veiculo = $veiculo->filtrar(10);
        foreach ($veiculo as $v){
            if($v->disponivel == "Concluida"){
                $v->disponivel = "Disponivel";
            }else if($v->disponivel == "Em andamento"){
                $v->disponivel = "Em uso";
            }
        }
        return view('admin.consultar_veiculo', compact('veiculo','filtros'));
    }
}
