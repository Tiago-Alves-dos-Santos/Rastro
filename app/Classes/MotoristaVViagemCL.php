<?php
namespace App\Classes;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Classes\MotoristaCL;
use App\Classes\ViagemCl;
use App\Classes\VeiculoCL;
//models
use App\Models\Motorista;
use App\Models\Viagem;
use App\Models\Veiculo;
use App\Models\MotoristaVViagem;
class MotoristaVViagemCL
{
	private $motorista_cl;//MotoristaCL objeto
	private $viagem_cl;//ViagemCl objeto
	private $veiculo_cl;//VeiculoCL objeto
    //objetos models

    private $motorista;//Motorista objeto(model)
    private $viagem;//Viagem objeto(model)
    private $veiculo;//Veiculo objeto(model)

    /**
     * @return mixed
     */
    public function getMotoristaCl()
    {
        return $this->motorista_cl;
    }

    /**
     * @param mixed $motorista_cl
     */
    public function setMotoristaCl(MotoristaCL $motorista_cl): void
    {
        $this->motorista_cl = $motorista_cl;
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
    public function setViagemCl(ViagemCl $viagem_cl): void
    {
        $this->viagem_cl = $viagem_cl;
    }

    /**
     * @return mixed
     */
    public function getVeiculoCl()
    {
        return $this->veiculo_cl;
    }

    /**
     * @param mixed $veiculo_cl
     */
    public function setVeiculoCl(VeiculoCL $veiculo_cl): void
    {
        $this->veiculo_cl = $veiculo_cl;
    }

    /**
     * @return mixed
     */
    public function getMotorista()
    {
        return $this->motorista;
    }

    /**
     * @param mixed $motorista
     */
    public function setMotorista(Motorista $motorista): void
    {
        $this->motorista = $motorista;
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
     * @return mixed
     */
    public function getVeiculo()
    {
        return $this->veiculo;
    }

    /**
     * @param mixed $veiculo
     */
    public function setVeiculo(Veiculo $veiculo): void
    {
        $this->veiculo = $veiculo;
    }


    /**
     * Relaiza o cadastro em massa dos ids dos veiculos e motorista participantes de uma viagem
     * @param $ids_veiculos
     * @param $ids_motoristas
     * @param $placas
     */
    public function cadastrar($ids_veiculos,$ids_motoristas,$placas){
        $motorista_viagem = new MotoristaVViagem();

        for($i= 0; $i < count($ids_veiculos);$i++){
            MotoristaVViagem::create([
                "id_veiculo" => $ids_veiculos[$i],
                "id_motorista" => $ids_motoristas[$i],
                "placa" => $placas[$i],
                "id_viagem" => $this->getViagemCl()->getIdViagem()
            ]);
        }
    }

    /**
     * Realiza uma exlusao de todos os motorista e veiculos pertecentes a uma viagem
     * para depois realizar um cadastro
     * @param $ids_veiculos
     * @param $ids_motoristas
     * @param $placas
     */
    public function alterar($ids_veiculos,$ids_motoristas,$placas){
        $motorista_viagem = new MotoristaVViagem();
        //desabilitar foreng eys e deletar dados da viagem
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        MotoristaVViagem::where('id_viagem',$this->getViagemCl()->getIdViagem())->forceDelete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->cadastrar($ids_veiculos,$ids_motoristas,$placas);
    }
}
