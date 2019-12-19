<?php
namespace App\Classes;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
class ClienteCL
{
    private $id_cliente;//int(11)
    private $nome;//string
    private $passaporte;//string
    private $telefone;//string
    private $cpf;//string
    private $data_nasc;//date
    private $pais;//string país
    private $cidade;//string



    /**
     * @return mixed
     */
    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    /**
     * @param mixed $id_cliente
     */
    public function setIdCliente($id_cliente): void
    {
        $this->id_cliente = $id_cliente;
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
     */
    public function setNome($nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getPassaporte()
    {
        return $this->passaporte;
    }

    /**
     * @param mixed $passaporte
     */
    public function setPassaporte($passaporte): void
    {
        $this->passaporte = $passaporte;
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
     */
    public function setTelefone($telefone): void
    {
        $this->telefone = $telefone;
    }

    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */

    /**
     * @return mixed
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * @param mixed $pais
     */
    public function setPais($pais): void
    {
        $this->pais = $pais;
    }

    /**
     * @return mixed
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param mixed $cidade
     */
    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }//string


    /**
     * @return mixed
     */
    public function getDataNasc()
    {
        return $this->data_nasc;
    }

    /**
     * @param $data_nasc
     */
    public function setDataNasc($data_nasc)
    {
        //converte a data para formato sql ano/mes/dia
        $data = date("Y-m-d", strtotime($data_nasc));
        $this->data_nasc = $data;
    }


    /**
     * @param $cpf
     * recebe um parametro cpf que recebe o cpf faz a validação do mesmo
     * @return bool
     * true == cpf valido, false == cpf invalido
     */
    public function validaCPF($cpf) {

        // Verifica se um número foi informado
        if(empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequências invalidas abaixo
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Verfica se cpf já é existente no banco de dados
     * @return bool
     * true == cpf ja existe, false == cpf inexistente
     */
    public function verficarCpf()
    {
        //se cpf recebido for vazio retorna como cpf inexistente, por mais q o vazio do cpf exista no banco
        if ($this->getCpf() == ""){
            return false;
        }
        $count = Cliente::where("cpf",$this->getCpf())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Verfica passaportes existentes no banco
     * @return bool
     * true == passaporte existe, false == cpf inexistente
     */
    public function verficarPassaporte(){
        //caso passaporte recebido seja igual a vazio, retorna como inexistente por mais que o vazio exista no
        // banco na coluna passaporte
        if($this->getPassaporte() == ""){
            return false;
        }
        $count = Cliente::where("passaporte",$this->getPassaporte())->count();
        if ($count > 0){
            return true;
        }else{
            return false;
        }
    }

    public function verficarExistenciaTelefone(){
        $count = Cliente::where('telefone',$this->getTelefone())->count();
        if ($count > 0){
            return true;
        }else{
            return false;
        }
    }
    /**
     * Metodo usado para alteração de cpf, verfica a existencia de cpf no banco exeto a do mesmo que esta
     * fazendo a alteração
     * @return bool
     * true == existe outro cpf igual fora o mesmo, false == nao existem cpf iguais fora o mesmo
     */
    public function existenciaCpfAlter()
    {
        $count = Cliente::where("cpf",$this->getCpf())->where("cpf","<>", null)->where("id_cliente","<>",$this->getIdCliente())->count();

        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo usado para alteração de passaporte, verfica a existencia de passaporte
     * no banco exeto a do mesmo que esta fazendo a alteração
     * @return bool
     * true == existe outro passaporte igual fora o mesmo, false == nao existem passaporte iguais fora o
     * mesmo
     */
    public function existenciaPassaporteAlter(){
        $count = Cliente::where("passaporte",$this->getPassaporte())->where("passaporte","<>", null)->where("id_cliente","<>",$this->getIdCliente())->count();

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
        $cliente = Cliente::where($coluna,$valor)->first();
        return $cliente;
    }

    public function filtrar($paginas){
       $cliente = Cliente::where('nome','like','%'.$this->getNome().'%')->orWhere('cpf','like','%'.$this->getCpf().'%')->orWhere('passaporte','like','%'.$this->getPassaporte().'%')->orWhere('data_nasc','like','%'.$this->getDataNasc().'%')->orWhere('telefone','like','%'.$this->getTelefone().'%')->orderBy('nome','asc')->paginate($paginas);
        return $cliente;
    }
    /**
     * Efetua o cadastro do cliente, nao retorna nada
     */
    public function cadastrar()
    {
        $cliente = new Cliente();
        $cliente->nome = $this->getNome();
        $cliente->telefone = $this->getTelefone();
        $cliente->passaporte = $this->getPassaporte();
        $cliente->cpf = $this->getCpf();
        $cliente->data_nasc = $this->getDataNasc();
        $cliente->pais = $this->getPais();
        $cliente->cidade = $this->getCidade();
        $cliente->save();
    }

    /**
     * Efetua a alteração do cliente
     */
    public function alterar()
    {
        Cliente::where("id_cliente",$this->getIdCliente())->update([
            "nome"=> $this->getNome(),
            "telefone" => $this->getTelefone(),
            "cpf" => $this->getCpf(),
            "passaporte" => $this->getPassaporte(),
            "data_nasc" => $this->getDataNasc(),
            "pais" => $this->getPais(),
            "cidade" => $this->getCidade()
        ]);
    }

}
