<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//models
use App\Models\Usuario;
//classes
use App\Classes\UsuarioCL;
class UsuarioC extends Controller
{
    public function login(Request $req)
    {
        //instancia o usuario
    	$usuario = new UsuarioCL();
    	try {
            //seta valores para validar
    		$usuario->setLogin($req->login);
    		$usuario->setSenha($req->senha);
    		//varaivel recebe valor da existencia
    		$existe = $usuario->verficarExistencia();
    		if ($existe) {
    			//busca cada atributo do banco referente ao usuario
    			$usu = Usuario::where("login",$usuario->getLogin())->where("senha",$usuario->getSenha())->first();
                //atribui valores a sessao do usuario logado
                session(["id_usuario"=>$usu->id_usuario]);
                session(["nome"=>$usu->nome]);
                session(["tipo_usuario" =>$usu->tipo_usuario]);
                session(["login" =>$usu->login]);
                session(["senha" =>$usu->senha]);
                session(["cargo" =>$usu->cargo]);
                session(["logado" => true]);

    			//verfica se o tipo é administrador
    			if ($usu->tipo_usuario == "administrador") {
    				return redirect()->route("admin.home");
    			}else{
    				//caso tipo == a 'usuario' ou 'inexistente', vai para pagina home
    				//verficar se o acesso esta liberado
    				return redirect()->route("user.home");
    			}
    		}else{
                //caso usuario inexistente cria msg  deaviso
    			session(['msg' => "Usuario inexistente na base de dados"]);
    			return redirect()->route("inicio");
    		}
    	} catch (Exception $e) {
            //caso aconteça algum erro exibe na tela exeção
    		session(['msg' => $e->getMessage()]);
    		return redirect()->route("inicio");
    	}
    }
    //encerra todas as sessoes e altera valor logado do usuario para false
    public function logout(Request $req)
    {
    	//destroi toda a sessao do usuario e redireciona para o inicio
        session()->flush();
        session(["msg"=>"Logout efetuado com sucesso!"]);
        return redirect()->route("inicio");
    }

    public function cadastrar(Request $req)
    {
        $usuario = new UsuarioCL();
        //verfica campos nulos e existencia do usuario, caso alguma
        //seja verdadeira retorna para a area de cadastro
        if ($req->nome == "" || $req->login == "" || $req->senha == "") {
            session(['msg' => "Um dos campos nome,login ou(e) senha estão vazios! Verfique!"]);
            return redirect()->route("create.usuario");
        }else if ($usuario->verficarExistencia()) {
            session(['msg' => "Impossivel cadastrar! Login ou senha já existente no banco!"]);
            return redirect()->route("create.usuario");
        }
        //seta os valores para serem validados
        $usuario->setNome($req->nome);
        $usuario->setLogin($req->login);
        $usuario->setSenha($req->senha);
        $usuario->setCargo($req->cargo);
        $usuario->setTipoUsuario($req->tipo_usuario);
        //realiza o cadastro
        $usuario->cadastrar();
        session(['msg' => "Usuario cadastrado com sucesso!"]);
        return redirect()->route("create.usuario");

    }

    public function alterar(Request $req)
    {
        $usuario = new UsuarioCL();
        //seta o id q recebe da view
        $usuario->setIdUsuario((int)$req->id_usuario);
        //verfica campos nulos
        if ($req->nome == "" || $req->login == "" || $req->senha == "") {
            session(['msg' => "Um dos campos nome,login ou(e) senha estão vazios! Verfique!"]);
            return redirect()->route('alter.usuario',['id'=> $usuario->getIdUsuario()]);
        }
        //seta valores para validação
        $usuario->setNome($req->nome);
        $usuario->setLogin($req->login);
        $usuario->setSenha($req->senha);
        $usuario->setCargo($req->cargo);
        $usuario->setTipoUsuario($req->tipo_usuario);
        //verfica se a existencia de usuario, buscando todos os usuarios fora o mesmo
        //ja que o mesmo ja existe pois se trata de uma alteração
        $existe = Usuario::where("senha",$usuario->getSenha())->where("login",$usuario->getLogin())->where("id_usuario", "<>",$usuario->getIdUsuario())->count();

        //Se existe manda aviso, se nao faz a alteração
        if ($existe > 0) {
            session(['msg' => "Login ou senha já existente no banco!"]);
            return redirect()->route('alter.usuario',['id'=> $usuario->getIdUsuario()]);
        }else{
            $usuario->alterar();
            session(['msg' => "Usuario alterado com sucesso!"]);
            return redirect()->route("read.usuario");
        }

    }

    public function filtrar(Request $req){
        if(is_null($req->nome)){
            $req->nome = "*1";
        }
        if(is_null($req->tipo_usuario)){
            $req->tipo_usuario = "*";
        }
        $filtro = $req->except(['_token']);
        $usuario = new UsuarioCL();
        $usuario->setNome($req->nome);
        $usuario->setTipoUsuario($req->tipo_usuario);
        $usuario = $usuario->filtrar(1);
        return view('admin.consultar_usuario', compact('usuario','filtro'));

    }


}
