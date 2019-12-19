<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Classes\MotoristaCL;
use App\Classes\ClienteCL;
use App\Models\Motorista;

class MotoristaC extends Controller
{
    public function cadastrar(Request $req)
    {
        //instancia feita no começo para validar os cpfs
        $cliente = new ClienteCL();
        $motorista = new MotoristaCL();
    	//verfica campos nulos, tamanhos incorretos de rg e cpf
    	//verfica se o cpf é valido
    	if ($req->nome == "") {
            session(["msg"=>"Por favor! Informe um nome não vazio"]);
            return redirect()->route("create.motorista");
        }else if (strlen($req->cpf) < 12 && strlen($req->cpf)> 1) {
            session(["msg"=>"Por favor! Informe o cpf com tamanho certo"]);
            return redirect()->route("create.motorista");
        }else if (!$motorista->validaCPF($req->cpf) && $req->cpf != "") {
            session(["msg"=>"Por favor! Informe um cpf valido"]);
            return redirect()->route("create.motorista");
        }else if ($req->vinculo == "") {
        	session(["msg"=>"Por favor! Selecione o tipo de vinculo do motorista com a empresa!"]);
            return redirect()->route("create.motorista");
        }
        //recebe o arquivo e o aloca em local temporario
    	$arquivo = $_FILES['ft_motorista'];

    	//verfica se arquivo esta com algum erro, nao importa se o envio esta vazio
    	//ou nao,, a verficação funcionara
    	//o codigo aq em cima facilitara mais para baixo
    	$erro = $arquivo['error'];

    	switch ($erro) {
    		case 1:
    			session(["msg"=>"Arquivo de foto atingiu o tamanho máximo no PHP"]);
            	return redirect()->route("create.motorista");
    			break;

    		case 2:
    			session(["msg"=>"Arquivo atingiu o tamanho máximo no HTML."]);
            	return redirect()->route("create.motorista");
    			break;
    		case 3:
    			session(["msg"=>"Arquivo foi parcialmente carregado."]);
            	return redirect()->route("create.motorista");
    			break;
    		case 4:
            //o erro 4 verfica e obriga o arquivo a nao ter valor nulo,
            //descomente o codigo abaixo para usar isso
    			// session(["msg"=>"Erro: arquivo não carregado."]);
       //      	return redirect()->route("create.motorista");
    			break;
    	}
    	//especifico o diretorio de upload, muito cuidado ao alterar o diretorio
    	//certifique-se de q pasta ja esta existente para evitar erros
    	$diretorio_upload = "upload/motorista/";
    	//colocos os valores no set do objeto para validar

    	$motorista->setNome($req->nome);
    	$motorista->setAgenciaBanco($req->agencia);
    	$motorista->setContaBanco($req->conta);
    	$motorista->setCpf($req->cpf);
    	$motorista->setVinculo($req->vinculo);
        //instancia cliente para verifcação de cpf e rg apenas

        $cliente->setCpf($motorista->getCpf());

        //se cpf ou rg de cliente ou motorista existir nao faz o cadastro, nem upload de foto
        if ($cliente->verficarCpf() || $motorista->verficarCpf() || $motorista->verficarConta()) {
            session(["msg"=>"Impossivel cadastrar! CPF ou conta bancaria já existente na base de dados!"]);
            return redirect()->route("create.motorista");

        }else{
            //realiza o  cadastro
            $motorista->cadastrar();
        }

        if ($arquivo['name'] != "") {
    		//caso foto enviado, vamos renomear a foto para o id do motorista a ser cadastrado
    		//
    		//pegar o ultimo id_motorista cadastrado
	    	$id_motorista = (int)DB::getPdo()->lastInsertId();
            $motorista->setIdMotorista($id_motorista);
	    	//separando nome e extensao de arquivo
	    	$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
	    	//coloca o novo nome como id_motorista
	    	$arquivo['name'] = (string)$motorista->getIdMotorista();
	    	//salva o novo nome
	    	$novo_nome = $arquivo['name'] . "." . $extensao;

	    	//verfica se  upload final irar da certo
	    	if (move_uploaded_file($arquivo['tmp_name'], $diretorio_upload . $arquivo['name'] . "." . $extensao)) {
	    		$diretorio_upload .= $novo_nome;
	    		$motorista->setFoto($diretorio_upload);
                Motorista::where("id_motorista",$motorista->getIdMotorista())->update(["foto"=>$motorista->getFoto()]);
			}else {
			    session(["msg"=>"Erro ao tentar fazer upload de imagem, atribuimos a foto padrao"]);
                $diretorio_upload .= "foto_padrao.png";
                $motorista->setFoto($diretorio_upload);
                Motorista::where("id_motorista",$motorista->getIdMotorista())->update(["foto"=>$motorista->getFoto()]);
            	return redirect()->route("create.motorista");
			}
    	}else{
    		//caso arquivo não enviado, vamos atribuir a foto padrao, como a foto é padrao
            //nao preciamos fazer o upload da mesma
    		$diretorio_upload .= "foto_padrao.png";
    		$motorista->setFoto($diretorio_upload);
            //pegar o ultimo id_motorista cadastrado
            $id_motorista = (int)DB::getPdo()->lastInsertId();
            $motorista->setIdMotorista($id_motorista);
            Motorista::where("id_motorista",$motorista->getIdMotorista())->update(["foto"=>$motorista->getFoto()]);
    	}
        session(["msg"=>"Cadastro reliazado com sucesso"]);
        return redirect()->route("create.motorista");
    }

    public function alterar(Request $req)
    {
        //instancia feita no começo para validar os cpfs
        $cliente = new ClienteCL();
        $motorista = new MotoristaCL();
        $motorista->setIdMotorista((int) $req->id_motorista);
        //dd($_FILES['ft_motorista']);
        //verfica campos nulos, tamanhos incorretos de rg e cpf
        //verfica se o cpf é valido
        if ($req->nome == "") {
            session(["msg"=>"Por favor! Informe um nome não vazio"]);
            return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
        }else if (strlen($req->cpf) < 12 && strlen($req->cpf)> 1) {
            session(["msg"=>"Por favor! Informe o cpf com tamanho certo"]);
            return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
        }else if (!$motorista->validaCPF($req->cpf) && $req->cpf != "") {
            session(["msg"=>"Por favor! Informe um cpf valido"]);
            return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
        }else if ($req->vinculo == "") {
            session(["msg"=>"Por favor! Selecione o tipo de vinculo do motorista com a empresa!"]);
            return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
        }
        //recebe o arquivo e o aloca em local temporario
        $arquivo = $_FILES['ft_motorista'];

        //verfica se arquivo esta com algum erro, nao importa se o envio esta vazio
        //ou nao,, a verficação funcionara
        //o codigo aq em cima facilitara mais para baixo
        $erro = $arquivo['error'];

        switch ($erro) {
            case 1:
                session(["msg"=>"Arquivo de foto atingiu o tamanho máximo no PHP"]);
                return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
                break;

            case 2:
                session(["msg"=>"Arquivo atingiu o tamanho máximo no HTML."]);
                return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
                break;
            case 3:
                session(["msg"=>"Arquivo foi parcialmente carregado."]);
                return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);
                break;
            case 4:
            //o erro 4 verfica e obriga o arquivo a nao ter valor nulo,
            //descomente o codigo abaixo para usar isso
                // session(["msg"=>"Erro: arquivo não carregado."]);
       //       return redirect()->route("create.motorista");
                break;
        }
        //especifico o diretorio de upload, muito cuidado ao alterar o diretorio
        //certifique-se de q pasta ja esta existente para evitar erros
        $diretorio = "upload/motorista/";
        //colocos os valores no set do objeto para validar

        $motorista->setNome($req->nome);
        $motorista->setContaBanco($req->conta);
        $motorista->setAgenciaBanco($req->agencia);
        $motorista->setCpf($req->cpf);
        $motorista->setVinculo($req->vinculo);
        //instancia cliente para verifcação de cpf e rg apenas

        $cliente->setCpf($motorista->getCpf());

        //se cpf ou rg de cliente ou motorista existir nao faz o cadastro, nem upload de foto
        if ($cliente->verficarCpf() || $motorista->existenciaCpfAlter() || $motorista->existenciaContaAlter()) {
            session(["msg"=>"Impossivel cadastrar! CPF ou Conta já existente na base de dados!"]);
            return redirect()->route("alter.motorista",['id'=>$motorista->getIdMotorista()]);

        }else{
            //realiza a alteração
            $motorista->alterar();
        }

        if ($arquivo['name'] != "") {
            $motorista_alterado = Motorista::where("id_motorista",$motorista->getIdMotorista())->first();
            if ($motorista_alterado->foto != $diretorio."foto_padrao.png") {
                unlink($motorista_alterado->foto);
            }

            //pego a extensao do arquivo
            $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
            //atribuo o id como nome da img
            $arquivo['name'] = (string) $motorista->getIdMotorista();
            //adiciono a extensao ao novo nome
            $novo_nome = $arquivo['name'].".".$extensao;
            //defino o diretorio final
            $diretorio_final = $diretorio.$novo_nome;
            //verfica se  upload final irar da certo
            if (move_uploaded_file($arquivo['tmp_name'], $diretorio_final)) {
                $motorista->setFoto($diretorio_final);
                Motorista::where("id_motorista",$motorista->getIdMotorista())->update(["foto"=>$motorista->getFoto()]);

            }else {
                //em caso de erro coloca img padrao
                session(["msg"=>"Erro ao tentar fazer upload de imagem, atribuimos a foto padrao"]);
                $diretorio .= "foto_padrao.png";
                $motorista->setFoto($diretorio);
                Motorista::where("id_motorista",$motorista->getIdMotorista())->update(["foto"=>$motorista->getFoto()]);
                return redirect()->route("read.motorista");
            }
        }

        session(["msg"=>"Alteração realizada com sucesso!"]);
        return redirect()->route("read.motorista");
    }

    public function filtrar(Request $req){
        if(is_null($req->nome)){
            $req->nome = "*$";
        }
        if(is_null($req->cpf)){
            $req->cpf = "*";
        }
        if(is_null($req->vinculo)){
            $req->vinculo = "*";
        }
        if(is_null($req->disponibilidade)){
            $req->disponibilidade = "*";
        }
        $filtro = $req->except(['_token']);
        $motorista = new MotoristaCL();
        $motorista->setNome($req->nome);
        $motorista->setCpf($req->cpf);
        $motorista->setStatusMotorista($req->disponibilidade);
        $motorista->setVinculo($req->vinculo);
        $motorista = $motorista->filtrar(10);
        foreach ($motorista as $m){
            if($m->status_motorista == "Concluida"){
                $m->status_motorista = "Disponivel";
            }else if($m->status_motorista == "Em andamento"){
                $m->status_motorista = "Em uso";
            }
        }
        return view('admin.consultar_motorista', compact('motorista','filtro'));
    }
}
