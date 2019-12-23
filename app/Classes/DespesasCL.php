<?php


namespace App\Classes;
use Illuminate\Support\Facades\DB;
use App\Models\Despesas;
use App\Models\Motorista;
//classes
use App\Classes\MotoristaCL;
class DespesasCL
{
    private $id_dispesa;//int(11)
    private $descricao;//string
    private $data;//data
    private $preco;//double
    private $motorista;//objeto motorista, nao inicializado
    private $motorista_cl;

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
     * Retorna um da base de dados, Motorista != MotoristaCL
     * @return Motorista
     */
    public function getMotorista()
    {
        return $this->motorista;
    }

    /**
     * Seta um motorista vindo de um model e nao
     * de uma classe
     * @param mixed $motorista
     */
    public function setMotorista(Motorista $motorista): void
    {
        $this->motorista = $motorista;
    }//Objeto motorista



    /**
     * @return mixed
     */
    public function getIdDispesa()
    {
        return $this->id_dispesa;
    }

    /**
     * @param mixed $id_dispesa
     */
    public function setIdDispesa($id_dispesa): void
    {
        $this->id_dispesa = $id_dispesa;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Recebe uma data com formato padrao(format), mas vc pode alterar esse padrao
     * @param $data
     * @param string $format
     */
    public function setData($data,$format='Y/m/d'): void
    {
        $data = date($format, strtotime($data));
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * @param mixed $preco
     */
    public function setPreco($preco):void
    {
        $this->preco = $preco;
    }

    /**
     * Realiza uma busca em aglumas colunas com a regra ou entre elas, e retorna por uma paginação
     * @param $paginas
     * @return mixed
     */
    public function filtrar($paginas){
        $despesa = Despesas::where('id_motorista',$this->getMotoristaCl()->getIdMotorista())->where('data','like','%'.$this->getData().'%')->orWhere('preco','like','%'.$this->getPreco().'%')->orderBy('data','desc')->paginate($paginas);

        return $despesa;
    }

    /**
     * Realiza o cadastro de despesa em um motorista
     */
    public function cadastrar(){
        $despesa = new Despesas();
        $despesa->descricao = $this->getDescricao();
        $despesa->data = $this->getData();
        $despesa->preco = $this->getPreco();
        $despesa->id_motorista = $this->getMotorista()->id_motorista;
        $despesa->save();
    }

    /**
     * Realiza a alteração de uma despesa
     */
    public function alterar(){
        Despesas::where("id_dispesas",$this->getIdDispesa())->update([
            "descricao" => $this->getDescricao(),
            "data" => $this->getData(),
            "preco" => $this->getPreco()
        ]);
    }

    /**
     * Realiza a exclusao de uma despesa
     */
    public function excluir(){
        Despesas::where("id_dispesas",$this->getIdDispesa())->forceDelete();
    }
}
