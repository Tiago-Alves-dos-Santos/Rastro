<?php
namespace App\Classes;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Fornecedor;
class FornecedorCL
{
    private $id_fornecedor;//int(11)
    private $nome;//string
    private $telefone;//string
    private $email;//string



    /**
     * @return mixed
     */
    public function getIdFornecedor()
    {
        return $this->id_fornecedor;
    }

    /**
     * @param mixed $id_fornecedor
     *
     * @return self
     */
    public function setIdFornecedor($id_fornecedor)
    {
        $this->id_fornecedor = $id_fornecedor;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     *
     * @return self
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * @param mixed $telefone
     *
     * @return self
     */
    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Verfica se existe outro email igual ja existente na base de dados
     * @return bool
     * true == existe, false == inexistente
     */
    public function verficarExistenciaEmail()
    {
        $count = Fornecedor::where("email",$this->getEmail())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo usado para verficaçção de alteração, verfica se existe algum email existente igual o email
     * a ser alterado, so nao verfica o mesmo
     * @return bool
     * true == existe, false == inexistente
     */
    public function existenciaEmailAlter()
    {
        $count = Fornecedor::where("email",$this->getEmail())->where("id_fornecedor","<>",$this->getIdFornecedor())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Retorna um objeto model a partir do valor buscado em um coluna, a coluna tem q possuir a valor unico
     * para o objeto buscado vir corretamente
     * @param $coluna
     * @param $valor
     * @return mixed
     */
    public function getObjetcColVal($coluna,$valor){
        $fornecedor = Fornecedor::where($coluna,$valor)->first();
        return $fornecedor;
    }

    public function filtrar($paginas){
        $fornecedor = Fornecedor::where('nome','like','%'.$this->getNome().'%')->orWhere('email','like','%'.$this->getEmail().'%')->orderBy('nome','asc')->paginate($paginas);
        return $fornecedor;
    }
    /**
     * Realiza o cadastro de fornecedor
     */
    public function cadastrar()
    {
        $fornecedor = new Fornecedor();
        $fornecedor->nome = $this->getNome();
        $fornecedor->telefone = $this->getTelefone();
        $fornecedor->email = $this->getEmail();
        $fornecedor->save();
    }

    /**
     * Realiza cadastro de alteração
     */
    public function alterar()
    {
        Fornecedor::where("id_fornecedor",$this->getIdFornecedor())->update([
            "nome" => $this->getNome(),
            "telefone" => $this->getTelefone(),
            "email" => $this->getEmail()
        ]);
    }
}
