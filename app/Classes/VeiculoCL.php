<?php
namespace App\Classes;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Veiculo;
class VeiculoCL
{
    private $id_veiculo;//int(11)
    private $placa;//string
    private $marca;//string
    private $modelo;//string
    private $propietario;//string
    private $foto;//string
    private $ano;//date
    private $capacidade_maxima;
    private $disponivel;//string(disponivel, indisponivel)
    private $vinculo;//string(interno,externo)
    private $tipo;//string

    /**
     * @return mixed
     */
    public function getIdVeiculo()
    {
        return $this->id_veiculo;
    }

    /**
     * @param $id_veiculo
     * @throws Exception
     */
    public function setIdVeiculo($id_veiculo)
    {
        if (is_int($id_veiculo)) {
            $this->id_veiculo = $id_veiculo;
        }else{
            throw new Exception("O id_veiculo VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * @param $placa
     * @throws Exception
     */
    public function setPlaca($placa)
    {
        if (is_string($placa)) {
            $this->placa = $placa;
        }else{
            throw new Exception("O placa VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param $marca
     * @throws Exception
     */
    public function setMarca($marca)
    {
        if (is_string($marca)) {
            $this->marca = $marca;
        }else{
            throw new Exception("O marca VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param $modelo
     * @throws Exception
     */
    public function setModelo($modelo)
    {
        if (is_string($modelo)) {
            $this->modelo = $modelo;
        }else{
            throw new Exception("O modelo VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getPropietario()
    {
        return $this->propietario;
    }

    /**
     * @param $propietario
     * @throws Exception
     */
    public function setPropietario($propietario)
    {
        if (is_string($propietario)) {
            $this->propietario = $propietario;
        }else{
            throw new Exception("O propietario VeiculoCL esta em um formato invalido");
        }
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
        if (is_string($foto)) {
            $this->foto = $foto;
        }else{
            throw new Exception("O foto VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param $ano
     * @return $this
     */
    public function setAno($ano)
    {
        $this->ano = $ano;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCapacidadeMaxima()
    {
        return $this->capacidade_maxima;
    }

    /**
     * @param $capacidade_maxima
     * @throws Exception
     */
    public function setCapacidadeMaxima($capacidade_maxima)
    {
        if (is_int($capacidade_maxima)) {
            $this->capacidade_maxima = $capacidade_maxima;
        }else{
            throw new Exception("O capacidade_maxima VeiculoCL esta em um formato invalido");
        }
    }

    /**
     * @return mixed
     */
    public function getDisponivel()
    {
        return $this->disponivel;
    }

    /**
     * @param $disponivel
     */
    public function setDisponivel($disponivel)
    {
        $this->disponivel = $disponivel;
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
     * @throws Exception
     */
    public function setVinculo($vinculo)
    {
        $this->vinculo = $vinculo;
    }
    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param $tipo
     * @return $this
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Verfica a existencia de um veiculo no banco pela placa
     * @return bool
     * true == existe
     * false == inexistente
     */
    public function verficarExistencia()
    {
        $count = Veiculo::where("placa",$this->getPlaca())->count();
        if ($count >= 1) {
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
        $veiculo = Veiculo::where($coluna,$valor)->first();
        return $veiculo;
    }

    /**
     * Metodo usuado para alteração verifca placas existente no bancos exeto a do mesmo
     * @return bool
     * true == existe, false == inexistente
     */
    public function verficarExistenciaAlteracao()
    {
        $count = Veiculo::where("placa",$this->getPlaca())->where("id_veiculo","<>",$this->getIdVeiculo())->count();
        if ($count > 0) {
            return true;
        }else{
            return false;
        }
    }
    /**
     * Realiza uma busca em aglumas colunas com a regra ou entre elas, e retorna por uma paginação
     * @param $paginas
     * @return mixed
     */
    public function filtrar($paginas){
        $veiculo = Veiculo::where('placa','like','%'.$this->getPlaca().'%')->orWhere('propietario','like','%'.$this->getPropietario().'%')->orWhere('vinculo','like','%'.$this->getVinculo().'%')->orWhere('disponivel','like','%'.$this->getDisponivel().'%')->paginate($paginas);
        return $veiculo;
    }
    /**
     * Cadastra um veiculo
     * @param string $diretorio_foto
     * Parametro opcional, local onde as fotos sao armazenadas
     */
    public function cadastrar($diretorio_foto = "")
    {
        $veiculo = new Veiculo();
        $veiculo->placa = $this->getPlaca();
        $veiculo->marca = $this->getMarca();
        $veiculo->modelo = $this->getModelo();
        $veiculo->propietario = $this->getPropietario();
        $veiculo->ano = $this->getAno();
        $veiculo->capacidade_maxima = $this->getCapacidadeMaxima();
        $veiculo->vinculo = $this->getVinculo();
        $veiculo->tipo = $this->getTipo();
        $veiculo->foto_carro = $diretorio_foto;
        $veiculo->save();
    }

    /**
     * Realiza a alteração de veiculo, nao precisa alterar o diretorio da foto
     */
    public function alterar()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Veiculo::where("id_veiculo",$this->getIdVeiculo())->update([
            "placa" => $this->getPlaca(),
            "marca" => $this->getMarca(),
            "modelo" => $this->getModelo(),
            "propietario" => $this->getPropietario(),
            "ano" => $this->getAno(),
            "capacidade_maxima" => $this->getCapacidadeMaxima(),
            "vinculo" => $this->getVinculo(),
            "tipo" => $this->getTipo()
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


}
