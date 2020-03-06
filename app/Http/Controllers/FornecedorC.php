<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models\Fornecedor;
//classe
use App\Classes\FornecedorCL;
class FornecedorC extends Controller
{
    public function cadastrar(Request $req)
    {
        //instancia forncedor
    	$fornecedor = new FornecedorCL();
    	//seta valores para validação e para persistir o objeto
    	$fornecedor->setNome($req->nome);
    	$fornecedor->setTelefone($req->telefone);
    	$fornecedor->setEmail($req->email);
    	//verfica se email aser cadastrado já é existente
    	if ($fornecedor->verficarNome()) {
    		session(["msg"=>"O fornecedor a ser cadastrado já é existene na base de dados!"]);
    		return redirect()->route("create.fornecedor");
    	}else{
    		//realiza cadastro
    		$fornecedor->cadastrar();
    		session(["msg"=>"Fornecedor cadastrado com sucesso!"]);
    		return redirect()->route("create.fornecedor");
    	}

    }

    public function alterar(Request $req)
    {
        //instancia forncedor
        $fornecedor = new FornecedorCL();
        //seta valores para validação e para persistir o objeto
        $fornecedor->setIdFornecedor((int) $req->id_fornecedor);
        $fornecedor->setNome($req->nome);
        $fornecedor->setTelefone($req->telefone);
        $fornecedor->setEmail($req->email);
        if ($fornecedor->nomeAlter()) {
            session(["msg"=>"O fornecedor a ser alterado já é existene na base de dados!"]);
            return redirect()->route("read.fornecedor");
        }else{
            $fornecedor->alterar();
            session(["msg"=>"Fornecedor alterado com sucesso!"]);
            return redirect()->route("read.fornecedor");
        }
    }

    public function filtrar(Request $req){
        if(is_null($req->nome)){
            $req->nome = "*";
        }
        if(is_null($req->email)){
            $req->email = "*";
        }
        $filtro = $req->except(['_token']);
        $fornecedor = new FornecedorCL();
        $fornecedor->setNome($req->nome);
        $fornecedor->setEmail($req->email);
        $fornecedor = $fornecedor->filtrar(1);
        return view('admin.consultar_fornecedor', compact('fornecedor','filtro'));

    }
}
