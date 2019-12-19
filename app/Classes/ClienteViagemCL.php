<?php
namespace App\Classes;
/**
 *
 */

use App\Models\ClienteViagem;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Classes\ClienteCl;
use App\Classes\ViagemCL;
//models
use App\Models\Cliente;
use App\Models\Viagem;

class ClienteViagemCL
{
    private $cliente_cl;//ClienteCl objeto
    private $viagem_cl;//ViagemCL objeto
    private $quantidade;//int

    private $cliente;//Cliente objeto(model)
    private $viagem;//ViagemCL objeto(model)

    /**
     * @return mixed
     */
    public function getClienteCl()
    {
        return $this->cliente_cl;
    }

    /**
     * @param mixed $cliente_cl
     */
    public function setClienteCl(ClienteCl $cliente_cl): void
    {
        $this->cliente_cl = $cliente_cl;
    }

    /**
     * @return mixed
     */
    public function getViagemCl()
    {
        return $this->viagem_cl;
    }

    /**
     * @param mixed $viagem_cl
     */
    public function setViagemCl(ViagemCL $viagem_cl): void
    {
        $this->viagem_cl = $viagem_cl;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param mixed $quantidade
     */
    public function setQuantidade($quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente(Cliente $cliente): void
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getViagem()
    {
        return $this->viagem;
    }

    /**
     * @param mixed $viagem
     */
    public function setViagem(Viagem $viagem): void
    {
        $this->viagem = $viagem;
    }

    /**
     * Cadastra o id da viagem junto com id_cliente e quantidade de dependentes daquela viagem
     * para funcionar viagem e cliente precisam ter um id ou seja precisam estar cadastrados
     */
    public function cadastrar(){
        $cliente_viagem = new ClienteViagem();
        $cliente_viagem->id_cliente = $this->getClienteCl()->getIdCliente();
        $cliente_viagem->id_viagem = $this->getViagemCl()->getIdViagem();
        $cliente_viagem->quantidade_dependente = $this->getQuantidade();
        $cliente_viagem->save();
    }
    public function alterar(){
        ClienteViagem::where('id_viagem',$this->getViagemCl()->getIdViagem())->update([
           "id_cliente" => $this->getClienteCl()->getIdCliente(),
            "quantidade_dependente" => $this->getQuantidade()
        ]);
    }
}
