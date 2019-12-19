<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Despesas;
use App\Models\Motorista;
use App\Classes\DespesasCL;
use App\Classes\MotoristaCL;
class DespesasC extends Controller
{
    public function cadastrar(Request $req)
    {
        //instancia objetos depesas e motorista
        $despesas = new DespesasCL();
        $motorista = new MotoristaCL();
        //seta o nome do motorista
        $motorista->setNome($req->motorista);
        //verfica se o motorista existe no banco buscando pelo nome(cliente q pediu)
        if (!$motorista->verficarNome()){
            session(["msg"=>"O cliente a ser adicionado a despesa não existe!"]);
            return redirect()->route("create.despesa");
        }
        //resgata objeto(model) motorista pela coluna nome com valor do nome setado existente
        $motorista = $motorista->resgatarObjeto('nome',$motorista->getNome());

        //seta valores no objeto despesa
        $despesas->setDescricao($req->motivo);
        $despesas->setData($req->data);
        $despesas->setPreco($req->preco);
        $despesas->setMotorista($motorista);
        //cadastra a despesa
        $despesas->cadastrar();

        //cria um aviso de sucesso e redireciona
        session(["msg"=>"Cadastro de despesa incluido com sucesso"]);
        return redirect()->route("create.despesa");
    }

    public function alterar(Request $req){
        //instancia objetos motorista e despesas
        $motorista = new MotoristaCL();
        $despesa = new DespesasCL();
        //seta id no motorista
        $motorista->setIdMotorista((int) $req->id_motorista);
        ///seta valores no objeto despesa
        $despesa->setIdDispesa((int) $req->id_despesa);
        $despesa->setPreco($req->preco);
        $despesa->setDescricao($req->motivo);
        $despesa->setData($req->data);
        //realiza a alteração
        $despesa->alterar();

        //redirecionar para consulta de despesas de determinado motorista
        session(["msg"=>"A despesa foi alterada com sucesso!"]);
        return redirect()->route("read.despesa", ['id' => $motorista->getIdMotorista()]);
    }

    public function excluir(Request $req){
        //insatcia objeto motorista
        $motorista = new MotoristaCL();
        //seta id no motorista
        $motorista->setIdMotorista((int)$req->id_motorista_excluir);
        //instancia objeto depesa
        $despesas = new DespesasCL();
        //seta o id em despesa
        $despesas->setIdDispesa((int)$req->id_despesa);
        //realiza a exclusao da despesa
        $despesas->excluir();
        //redirecionar para consulta de despesas de determinado motorista
        session(["msg"=>"A despesa foi excluida com sucesso!"]);
        return redirect()->route("read.despesa", ['id' => $motorista->getIdMotorista()]);
    }

    public function filtrar(Request $req){
        if(is_null($req->preco)){
            $req->preco = "*";
        }
        if(is_null($req->mes)){
            $req->mes = "*";
        }
        $filtro = $req->except(['_token']);
        $motorista = new MotoristaCL();
        $motorista->setIdMotorista((int) $req->id_motorista);
        $id = $motorista->getIdMotorista();
        $despesa = new DespesasCL();
        $despesa->setMotoristaCl($motorista);
        $despesa->setPreco($req->preco);
        $despesa->setData($req->mes,'Y-m');
        $despesa = $despesa->filtrar(10);
        foreach ($despesa as $d) {
            $data = date("d/m/Y", strtotime($d->data));
            $d->data = $data;
        }
        return view('admin.consultar_despesa_motorista',compact('despesa','filtro','id'));
    }
}
