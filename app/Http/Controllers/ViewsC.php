<?php

namespace App\Http\Controllers;

use App\Classes\ViagemCL;
use App\Models\Despesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//classes
use App\Classes\UsuarioCL;
use App\Classes\ClienteCL;
use App\Classes\MotoristaCl;
use App\Classes\VeiculoCL;
use App\Classes\FornecedorCL;
//models
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Motorista;
use App\Models\Veiculo;
use App\Models\Fornecedor;
use App\Models\Viagem;
/**
 * Controller usudo para verificação de paginas, se usuario esta logado etc
 * Algumas paginas sao verficadas em outros controllers
 */
class ViewsC extends Controller
{
    //view home usuario
    public function homeUsuario(Request $req)
    {
    	//verfica se usuario esta logado
    	if (session("logado")== true) {
            $viagem = new ViagemCL();
            //recebe todas as viagens agrupadas por id, sem condiçção de data, a verficaçção da data é feita na view
            //do home usuario, como diz abaixo
            $viagem_grupo = $viagem->groupconsultarViagens();
    		return view("usuario.home", compact('viagem_grupo'));
    	}else{
    		session(['msg' => "Realize o login para acessar a pagina!"]);
    		return redirect()->route("inicio");
    	}
    }
    //view home admin
    public function homeAdmin(Request $req)
    {
    	//verfica se esta logado e se tipo e de adiministrador
    	if (session("logado")== true && session("tipo_usuario")  == "administrador") {
    	    $viagem = new ViagemCL();
            //recebe todas as viagens agrupadas por id, sem condiçção de data
            $viagem_grupo = $viagem->groupconsultarViagens();
    		return view("admin.home",compact('viagem_grupo'));
    	}else{
    		session(['msg' => "Você nao tem acesso a essa pagina!"]);
    		return redirect()->route("inicio");
    	}
    }
    //view agendar viagem
    public function agendarViagem(Request $req)
    {
        //verfica se usuario esta logado
        if (session("logado")== true) {
            //buscar fornecedor,veiculo,motorista,cliente, para fornecer dados
            //ao datalist e aos autocompletes
            $fornecedor = Fornecedor::orderBy('nome')->get();
            $veiculo = Veiculo::orderBy('placa')->get();
            $motorista = Motorista::orderBy('nome')->get();
            $cliente = Cliente::orderBy('nome')->get();
            return view("admin.agendar_viagem", compact('fornecedor','veiculo','motorista','cliente'));
        }else{
            session(['msg' => "Realize o login para acessar a pagina!"]);
            return redirect()->route("inicio");
        }
    }
    // cadastros
    //view cadastrar cliente
    public function cadastrarCliente(Request $req)
    {
        if (session("logado")== true ) {
            return view("usuario.cadastrar_cliente");
        }else{
            session(['msg' => "Realize o login para acessar a pagina!"]);
            return redirect()->route("inicio");
        }
    }
    //view cadastrar motorista
    public function cadastrarMotorista(Request $req)
    {
        //verfica se usuario esta logado e se é do tipo adminitrador
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            return view("admin.cadastrar_motorista");
        }else{
            session(['msg' => "Você nao tem acesso a essa pagina!"]);
            return redirect()->route("inicio");
        }
    }

    public function cadastrarDespesa(Request $req){
        //verfica se usuario esta logado e se é do tipo adminitrador
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            $motorista = Motorista::orderBy("nome","asc")->get();
            return view("admin.cadastrar_despesa_motorista", compact('motorista'));
        }else{
            session(['msg' => "Você nao tem acesso a essa pagina!"]);
            return redirect()->route("inicio");
        }
    }
    //cadastrar usuario
    public function cadastrarUsuario(Request $req)
    {
        //verfica se usuario esta logado e se é do tipo adminitrador
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            return view("admin.cadastrar_usuario");
        }else{
            session(['msg' => "Você nao tem acesso a essa pagina!"]);
            return redirect()->route("inicio");
        }
    }
    //cadastrar veiculo
    public function cadastrarVeiculo(Request $req)
    {
        //verfica se usuario esta logado e se é do tipo adminitrador
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //verfica categorias e modelos ja cadastrados, para ajudar nos datalists
            $veiculo_mod = Veiculo::select(DB::raw("modelo, count(*) as qtd"))->groupBy("modelo")->get();
            $veiculo_marca = Veiculo::select(DB::raw("marca, count(*) as qtd"))->groupBy("marca")->get();
            return view("admin.cadastrar_veiculo", compact('veiculo_mod','veiculo_marca'));
        }else{
            session(['msg' => "Você nao tem acesso a essa pagina!"]);
            return redirect()->route("inicio");
        }
    }

    public function cadastrarFornecedor(Request $req)
    {
        //verfica se usuario esta logado e se é do tipo adminitrador
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            return view("admin.cadastrar_fornecedor");
        }else{
            session(['msg' => "Você nao tem acesso a essa pagina!"]);
            return redirect()->route("inicio");
        }
    }
    //consultas
    //consultar clientes
    public function consultarCliente(Request $req)
    {
        //verfica se o usuario esta logado
        if (session("logado")== true) {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $cliente = Cliente::paginate(10);
            //converte a data para mostrar no formato normal
            foreach ($cliente as $c) {
                $data = date("d/m/Y", strtotime($c->data_nasc));
                $c->data_nasc = $data;
            }
            return view("usuario.consultar_cliente", compact('cliente'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    //cosulta usuario
    public function consultarUsuario(Request $req)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $usuario = Usuario::paginate(10);
            return view("admin.consultar_usuario",compact('usuario'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    //consultar motorista
    public function consultarMotorista(Request $req)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $motorista = Motorista::paginate(10);
            foreach ($motorista as $m){
                if($m->status_motorista == "Concluida"){
                    $m->status_motorista = "Disponivel";
                }else if($m->status_motorista == "Em andamento"){
                    $m->status_motorista = "Em uso";
                }
            }
            return view("admin.consultar_motorista",compact('motorista'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    //consultar veiculo
    public function consultarVeiculo(Request $req)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $veiculo = Veiculo::paginate(10);
            foreach ($veiculo as $v){
                if($v->disponivel == "Concluida"){
                    $v->disponivel = "Disponivel";
                }else if($v->disponivel == "Em andamento"){
                    $v->disponivel = "Em uso";
                }
            }
            return view("admin.consultar_veiculo", compact('veiculo'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    //consultar viagem usuario(talvez)

    //consultar viagem admin
    public function consultarViagem(Request $req)
    {
        if (session("logado")== true) {
            $viagem = new ViagemCL();
            if(session("tipo_usuario") == "administrador"){
                $viagem_model = $viagem->groupPaginate(10);
            }else{
                $viagem_model = $viagem->groupUserPaginate(10);
            }

            foreach ($viagem_model as $vg){
                $vg->data_inicio = date('d/m/Y',strtotime($vg->data_inicio));
                if(session("tipo_usuario") == "usuario"){
                    $vg->preco = "Sem permissão!";
                    $vg->valor_motorista = "Sem permissão!";
                }
            }
            return view("admin.consultar_viagem", compact('viagem_model'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function consultarFornecedor(Request $req)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $fornecedor = Fornecedor::paginate(10);
            return view("admin.consultar_fornecedor", compact('fornecedor'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function consultarDespesa($id){
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $despesa = Despesas::where('id_motorista', $id)->paginate(10);
            foreach ($despesa as $d) {
                $data = date("d/m/Y", strtotime($d->data));
                $d->data = $data;
            }
            return view("admin.consultar_despesa_motorista", compact('despesa','id'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    //alteraçoes
    public function alterarDespesa($id_depesa,$id_motorista){
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //faz um consulta sem filtros, divindo em 10 por pagina
            $motorista = Motorista::where('id_motorista',$id_motorista)->first();
            $despesa = Despesas::where('id_dispesas',$id_depesa)->first();
            return view("admin.alterar_despesa_motorista", compact('motorista','despesa'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }
    public function alterarUsuario($id)
    {
        //recebe um id da rota, que recebe da view que a mesma recebe de uma consulta
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $usuario = Usuario::where("id_usuario",$id)->first();
            //passa o usuario pertencente ao id para view
            return view("admin.alterar_usuario", compact('usuario'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function alterarCliente($id)
    {
        if (session("logado")== true) {
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $cliente = Cliente::where("id_cliente",$id)->first();
            //passa o usuario pertencente ao id para view
            return view("usuario.alterar_cliente", compact('cliente'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function alterarFornecedor($id)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $fornecedor = Fornecedor::where("id_fornecedor",$id)->first();
            //passa o usuario pertencente ao id para view
            return view("admin.alterar_fornecedor", compact('fornecedor'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function alterarVeiculo($id)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //agrupa e busca todos modelos exsitente, para fazer um select com autocomplete
            $veiculo_mod = Veiculo::select(DB::raw("modelo, count(*) as qtd"))->groupBy("modelo")->get();
            //agrupa e busca todas marcas exsitente, para fazer um select com autocomplete
            $veiculo_marca = Veiculo::select(DB::raw("marca, count(*) as qtd"))->groupBy("marca")->get();
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $veiculo = Veiculo::where("id_veiculo",$id)->first();
            //passa o usuario pertencente ao id para view
            return view("admin.alterar_veiculo", compact('veiculo_mod','veiculo_marca','veiculo'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function alterarMotorista($id)
    {
        if (session("logado")== true && session("tipo_usuario")  == "administrador") {
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $motorista = Motorista::where("id_motorista",$id)->first();
            //retira SSP dos orgao para automatizar o select
            return view("admin.alterar_motorista", compact('motorista'));
        }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function alterarViagem($id){
        if(session("logado")== true && session("tipo_usuario")  == "administrador") {
            //realiza uma busca pelo id obtido e retorna apenas um unico objeto
            $fornecedor = Fornecedor::orderBy('nome')->get();
            $veiculo = Veiculo::orderBy('placa')->get();
            $motorista = Motorista::orderBy('nome')->get();
            $cliente = Cliente::orderBy('nome')->get();
            $viagem = new ViagemCL();
            $viagem->setIdViagem($id);
            $viagem_model = $viagem->consultarViagem();
            $viagem_unica = $viagem->unicoRegistro();
//            dd($viagem_model);
        //retira SSP dos orgao para automatizar o select
        return view("admin.alterar_viagem", compact('viagem_model','viagem_unica','fornecedor','veiculo','motorista','cliente'));
    }else{
            session(['msg' => "Realize o login para ter acesso a pagina"]);
            return redirect()->route("inicio");
        }
    }

    public function emitirFatura(Request $req, $id_fornecedor)
    {
        $fornecedor = Fornecedor::where('id_fornecedor',$id_fornecedor)->first();
        return view('admin.fatura', compact('fornecedor'));
    }
}
