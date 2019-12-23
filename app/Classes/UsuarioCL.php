<?php
namespace App\Classes;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
class UsuarioCL
{
    private $id_usuario;//int(11)
    private $nome;//string
    private $login;//string
    private $senha;//strin
    private $cargo;//string
    private $tipo_usuario;//string("usuario, administrador")
    private $logado;//boolean

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param $id_usuario
     * @throws Exception
     */
    public function setIdUsuario($id_usuario)
    {
        if (is_int($id_usuario)) {
            $this->id_usuario = $id_usuario;
        }else{
            throw new Exception("O id_usuario UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param $nome
     * @throws Exception
     */
    public function setNome($nome)
    {
        if (is_string($nome)) {
            $this->nome = $nome;
        }else{
            throw new Exception("O nome UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param $login
     * @throws Exception
     */
    public function setLogin($login)
    {
        if (is_string($login)) {
            $this->login = $login;
        }else{
            throw new Exception("O login UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param $senha
     * @throws Exception
     */
    public function setSenha($senha)
    {
        if (is_string($senha)) {
            $this->senha = $senha;
        }else{
            throw new Exception("O senha UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * @param $cargo
     * @throws Exception
     */
    public function setCargo($cargo)
    {
        if (is_string($cargo) || $cargo == "") {
            $this->cargo = $cargo;
        }else{
            throw new Exception("O cargo UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getTipoUsuario()
    {
        return $this->tipo_usuario;
    }

    /**
     * Faz verficação se setagem obedece as opções
     * @param $tipo_usuario
     * @throws Exception
     */
    public function setTipoUsuario($tipo_usuario)
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    /**
     * @return mixed
     */
    public function getLogado()
    {
        return $this->logado;
    }

    /**
     * @param $logado
     * @throws Exception
     */
    public function setLogado($logado)
    {
        if (is_bool($logado)) {
            $this->logado = $logado;
        }else{
            throw new Exception("O logado UsuarioCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */


    /**
     * Verfica se existe um determinado usuario pelo login e a senha
     * @return bool
     */
    public function verficarExistencia()
    {
        $count = Usuario::where("login",$this->getLogin())->where("senha",$this->getSenha())->count();
        if ($count > 0) {
            //usuario existe
            return true;
        }else{
            //usuario nao existe
            return false;
        }
    }
    /**
     * Realiza uma busca em aglumas colunas com a regra ou entre elas, e retorna por uma paginação
     * @param $paginas
     * @return mixed
     */
    public function filtrar($paginas){
        $usuario = Usuario::where('nome','like','%'.$this->getNome().'%')->orWhere('tipo_usuario','like','%'.$this->getTipoUsuario().'%')->orderBy('nome','asc')->paginate($paginas);
        return $usuario;
    }

    /**
     * Realiza cadastro de usuario
     */
    public function cadastrar()
    {
        $usuario = new Usuario();
        $usuario->nome = $this->getNome();
        $usuario->login = $this->getLogin();
        $usuario->senha = $this->getSenha();
        $usuario->cargo = $this->getCargo();
        $usuario->tipo_usuario = $this->getTipoUsuario();;
        $usuario->save();
    }

    /**
     * realiza a alteraçaõ de usuario
     */
    public function alterar()
    {
        Usuario::where("id_usuario",$this->getIdUsuario())->update([
            "nome" => $this->getNome(),
            "login" => $this->getLogin(),
            "senha" => $this->getSenha(),
            "cargo" => $this->getCargo(),
            "tipo_usuario" => $this->getTipoUsuario()
        ]);
    }


}
