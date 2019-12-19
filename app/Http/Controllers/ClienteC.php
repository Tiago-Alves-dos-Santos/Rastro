<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models\Cliente;
//classes
use App\Classes\ClienteCL;
use App\Classes\MotoristaCL;
class ClienteC extends Controller
{
    public function cadastrar(Request $req)
    {
        //instancia cliente e motorista
        $cliente = new ClienteCL();
        $motorista = new MotoristaCL();
        //verfica campos nulos, valida cpf
        if ($req->nome == "") {
            session(["msg"=>"Por favor! Informe um nome não vazio"]);
            return redirect()->route("create.cliente");
        }else if ($req->cidade == "") {
            session(["msg"=>"Por favor! Informe uma cidade para o cliente!"]);
            return redirect()->route("create.cliente");
        }else if (strlen($req->cpf) < 12 && strlen($req->cpf)> 1) {
            session(["msg"=>"Por favor! Informe o cpf com tamanho certo"]);
            return redirect()->route("create.cliente");
        }else if (!$cliente->validaCPF($req->cpf) && $req->cpf != "") {
            session(["msg"=>"Por favor! Informe um cpf valido"]);
            return redirect()->route("create.cliente");
        }

        //seta os campos no set, para validar
        $cliente->setCpf($req->cpf);
        $cliente->setNome($req->nome);
        $cliente->setTelefone($req->telefone);
        $cliente->setPassaporte($req->passaporte);
        $cliente->setDataNasc($req->data);
        $cliente->setCidade($req->cidade);
        $cliente->setPais($req->pais);

        /** @var TYPE_NAME $motorista */
        $motorista->setCpf($cliente->getCpf());

        //se cpf ou rg de cliente ou motorista existir nao faz o cadastro
        if ($cliente->verficarCpf() || $cliente->verficarPassaporte() ||$motorista->verficarCpf()) {
        	if($cliente->getCpf() == ""){
                session(["msg"=>"Impossivel cadastrar! Passaporte já existente na base de dados!"]);
            }else{
                session(["msg"=>"Impossivel cadastrar! CPF já existente na base de dados!"]);
            }
            return redirect()->route("create.cliente");
        }else{
        	//se cliente nao existir faz o cadastro
        	$cliente->cadastrar();
        	session(["msg"=>"Cliente cadastrado com sucesso!"]);
            return redirect()->route("create.cliente");
        }
    }

    public function alterar(Request $req)
    {
        //instancia de cliente e  motorista
        $cliente = new ClienteCL();
        $motorista = new MotoristaCL();
        $cliente->setIdCliente((int)$req->id_cliente);
        if ($req->nome == "") {
            session(["msg"=>"Por favor! Informe um nome não vazio"]);
            return redirect()->route("alter.cliente", ['id'=>$cliente->getIdCliente()]);
        }else if ($req->cidade == "") {
            session(["msg"=>"Por favor! Informe uma cidade para o cliente!"]);
            return redirect()->route("alter.cliente", ['id'=>$cliente->getIdCliente()]);
        }else if (strlen($req->cpf) < 12 && strlen($req->cpf)> 1) {
            session(["msg"=>"Por favor! Informe o cpf com tamanho certo"]);
            return redirect()->route("alter.cliente", ['id'=>$cliente->getIdCliente()]);
        }else if (!$cliente->validaCPF($req->cpf) && $req->cpf != "") {
            session(["msg"=>"Por favor! Informe um cpf valido"]);
            return redirect()->route("alter.cliente", ['id'=>$cliente->getIdCliente()]);
        }

        //seta os campos no set, para validar
        $cliente->setCpf($req->cpf);
        $cliente->setNome($req->nome);
        $cliente->setTelefone($req->telefone);
        $cliente->setPassaporte($req->passaporte);
        $cliente->setDataNasc($req->data);
        $cliente->setCidade($req->cidade);
        $cliente->setPais($req->pais);

        $motorista->setCpf($cliente->getCpf());
        //verfica todos os cpfs de motorista e verfica todos cpf de clientes exeto o do mesmo
        //que esta fazendo a alteração
        if ($cliente->existenciaCpfAlter() || $cliente->existenciaPassaporteAlter() || $motorista->verficarCpf()) {
            //caso cpf ou passaporte existente, nao faz a alteração
            session(["msg"=>"Impossivel alterar! CPF ou passaporte já existente!"]);
            return redirect()->route("alter.cliente",['id'=>$cliente->getIdCliente()]);
        }else{
            $cliente->alterar();
            session(["msg"=>"Cliente alterado com sucesso!"]);
            return redirect()->route("read.cliente");
        }
    }

    public function filtrar(Request $req){
        $clientes = new ClienteCL();
        if ($req->nome == null || $req->nome == ""){
            $req->nome = "*";
        }
        if ($req->cpf == "" || $req->cpf == null){
            $req->cpf = "*";
        }
        if($req->passaporte == "" || $req->passaporte == null){
            $req->passaporte = "*";
        }
        if(is_null($req->tel)){
            $req->tel = "*";
        }
        if($req->data == "" || $req->data == null){
            $req->data = "*";
        }else{
            $req->data = str_replace('/','-',$req->data);

        }
        $filtro = $req->except(['_token']);
        $clientes->setDataNasc($req->data);
        $clientes->setNome($req->nome);
        $clientes->setCpf($req->cpf);
        $clientes->setPassaporte($req->passaporte);
        $clientes->setTelefone($req->tel);
        $cliente = $clientes->filtrar(10);
        foreach ($cliente as $c){
            $data = date("d/m/Y", strtotime($c->data_nasc));
            $c->data_nasc = $data;
        }
        return view('usuario.consultar_cliente', compact('cliente','filtro'));
    }
}
