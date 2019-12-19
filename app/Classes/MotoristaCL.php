<?php
namespace App\Classes;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Motorista;
class MotoristaCL
{
    private $id_motorista;//int(11)
    private $nome;//string
    private $cpf;//string
    private $status_motorista;//string(disponivel,indisponivel)
    private $vinculo;//string(externo,interno)
    private $foto;//string
    private $conta_banco;//string
    private $agencia_banco;//string

    /**
     * @return mixed
     */
    public function getContaBanco()
    {
        return $this->conta_banco;
    }

    /**
     * @param mixed $conta_banco
     */
    public function setContaBanco($conta_banco): void
    {
        $this->conta_banco = $conta_banco;
    }

    /**
     * @return mixed
     */
    public function getAgenciaBanco()
    {
        return $this->agencia_banco;
    }

    /**
     * @param mixed $agencia_banco
     */
    public function setAgenciaBanco($agencia_banco): void
    {
        $this->agencia_banco = $agencia_banco;
    }


    /**
     * @return mixed
     */
    public function getIdMotorista()
    {
        return $this->id_motorista;
    }

    /**
     * @param $id_motorista
     * @throws Exception
     */
    public function setIdMotorista($id_motorista)
    {
        if (is_int($id_motorista)) {
            $this->id_motorista = $id_motorista;
        }else{
            throw new Exception("O id_motorista MotoristaCL esta em um formato invalido");
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
            throw new Exception("O nome MotoristaCL esta em um formato invalido");
        }
    }


    /**
     * @return mixed
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param $cpf
     * @throws Exception
     */
    public function setCpf($cpf)
    {
        if (is_string($cpf) || $cpf == "") {
            $this->cpf = $cpf;
        }else{
            throw new Exception("O cpf MotoristaCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getStatusMotorista()
    {
        return $this->status_motorista;
    }

    /**
     * @param $status_motorista
     */
    public function setStatusMotorista($status_motorista)
    {
        $this->status_motorista = $status_motorista;
    }

    /**
     * @return mixed
     */
    public function getVinculo()
    {
        return $this->vinculo;
    }

    /**
     * @param $vinculo
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * @param $foto
     * @throws Exception
     */
    public function setFoto($foto)
    {
        if (is_string($foto) || $foto = "") {
            $this->foto = $foto;
        }else{
            throw new Exception("Foto esta com valor invalido");

        }
    }


    /**
     * @param $cpf
     * Recebe um cpf para validação
     * @return bool
     * true == existe, false == inexistente
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
        // 'Verifica' se nenhuma das sequências invalidas abaixo
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
     * Verica se existe cpf igual existente no banco
     * @return bool
     * true == existe, false == inexistente
     */
    public function verficarCpf()
    {
        if($this->getCpf() == ""){
            return false;
        }
        $count = Motorista::where("cpf",$this->getCpf())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Verifica se existe conta bancairia igual
     * @return bool
     * true == existe, false == inexistente
     */
    public function verficarConta(){
        $count = Motorista::where("conta_banco",$this->getContaBanco())->count();
        if ($count > 0){
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
        $motorista = Motorista::where($coluna,$valor)->first();
        return $motorista;
    }

    public function retornaID($nome){
        $motorista = Motorista::where('nome',$nome)->first();
        return $motorista->id_motorista;
    }
    /**
     * Metodo usado para alteração de cpf, verfica todos cpf, fora o cpf a ser alterado, se existe algum
     * igual
     * @return bool
     * true == existe, false == inexistente
     */
    public function existenciaCpfAlter()
    {
        $count = Motorista::where("cpf",$this->getCpf())->where("cpf","<>",null)->where("id_motorista","<>",$this->getIdMotorista())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }
    /**
     * Metodo usado para alteração de conta, verfica todas as contas, fora a conta a ser alterado, se existe
     * algum igual
     * @return bool
     * true == existe, false == inexistente
     */
    public function existenciaContaAlter(){
        $count = Motorista::where("conta_banco",$this->getContaBanco())->where("id_motorista","<>",$this->getIdMotorista())->count();
        if ($count > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Verfica se o nome digitado existe no banco
     * @return bool
     * true == existe, false == inexistente
     */
    public function verficarNome(){
        $count = Motorista::where("nome",$this->getNome())->count();
        if ($count > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Realiza uma busca em uma coluna escolhida da tabela motorista que contenha o valor colocado
     * @param $coluna
     * nome da coluna
     * @param $valor
     * valor da coluna
     * @return Motorista
     * retorna um objeto model Motorista, Motorista != MotoristaCL
     */
    public function resgatarObjeto($coluna,$valor){
        $motorista =  Motorista::where($coluna,$valor)->first();
        return $motorista;
    }

    public function filtrar($paginas){
        $motorista = Motorista::where('nome','like','%'.$this->getNome().'%')->orWhere('cpf','like','%'.$this->getCpf().'%')->orWhere('status_motorista','like','%'.$this->getStatusMotorista().'%')->orWhere('vinculo','like','%'.$this->getVinculo().'%')->orderBy('nome','asc')->paginate($paginas);
        return $motorista;
    }

    /**
     * Realiza o cadastro de motorista
     * @param string $foto
     * parametro opcional da foto
     */
    public function cadastrar($foto="")
    {
        $motorista = new Motorista();
        $motorista->nome = $this->getNome();
        $motorista->cpf = $this->getCpf();
        $motorista->vinculo = $this->getVinculo();
        $motorista->agencia_banco = $this->getAgenciaBanco();
        $motorista->conta_banco = $this->getContaBanco();
        $motorista->foto = $foto;
        $motorista->save();
    }

    /**
     * Realiza a alteração de motorista
     */
    public function alterar()
    {
        Motorista::where("id_motorista",$this->getIdMotorista())->update([
            "nome" => $this->getNome(),
            "agencia_banco" => $this->getAgenciaBanco(),
            "conta_banco" => $this->getContaBanco(),
            "cpf" => $this->getCpf(),
            "vinculo" => $this->getVinculo()
        ]);
    }


}
