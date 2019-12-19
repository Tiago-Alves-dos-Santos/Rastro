<?php
namespace App\Classes;
use App\Models\Viagem;
use Exception;
use App\Classes\FornecedorCL;
use App\Classes\ClienteViagemCL;
use App\Classes\MotoristaVViagemCL;
//models
use App\Models\Fornecedor;
use Illuminate\Support\Facades\DB;
class ViagemCL
{
    //localizador nao colocado, pois o id ja serve
    private $id_viagem;//int(11)
    private $fornecedor_cl;//UsuarioCL objeto
    private $fornecedor;//usuario objeto(model)
    private $destino;//string
    private $origem;//string
    private $local_origem;//string
    private $local_destino;//string
    public $data_inicio;//date
    private $data_termino;//date
    private $horario_saida;//timer
    private $horario_chegada;//timer
    public $preco;//double
    private $observacoes;//string
    public $status_viagem;//string(agendada,realizada,cancelada)

    /**
     * @return mixed
     */
    public function getIdViagem()
    {
        return $this->id_viagem;
    }

    /**
     * @param mixed $id_viagem
     */
    public function setIdViagem($id_viagem): void
    {
        $this->id_viagem = $id_viagem;
    }

    /**
     * @return mixed
     */
    public function getFornecedorCl()
    {
        return $this->fornecedor_cl;
    }

    /**
     * @param mixed $fornecedor_cl
     */
    public function setFornecedorCl(FornecedorCL $fornecedor_cl): void
    {
        $this->fornecedor_cl = $fornecedor_cl;
    }

    /**
     * @return mixed
     */
    public function getFornecedor()
    {
        return $this->fornecedor;
    }

    /**
     * @param mixed $fornecedor
     */
    public function setFornecedor(Fornecedor $fornecedor): void
    {
        $this->fornecedor = $fornecedor;
    }

    /**
     * @return mixed
     */
    public function getDestino()
    {
        return $this->destino;
    }

    /**
     * @param mixed $destino
     */
    public function setDestino($destino): void
    {
        $this->destino = $destino;
    }

    /**
     * @return mixed
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * @param mixed $origem
     */
    public function setOrigem($origem): void
    {
        $this->origem = $origem;
    }

    /**
     * @return mixed
     */
    public function getLocalOrigem()
    {
        return $this->local_origem;
    }

    /**
     * @param mixed $local_origem
     */
    public function setLocalOrigem($local_origem): void
    {
        $this->local_origem = $local_origem;
    }

    /**
     * @return mixed
     */
    public function getLocalDestino()
    {
        return $this->local_destino;
    }

    /**
     * @param mixed $local_destino
     */
    public function setLocalDestino($local_destino): void
    {
        $this->local_destino = $local_destino;
    }

    /**
     * @return mixed
     */
    public function getDataInicio()
    {
        return $this->data_inicio;
    }

    /**
     * @param mixed $data_inicio
     */
    public function setDataInicio($data_inicio): void
    {
        $data = date("Y/m/d", strtotime($data_inicio));
        $this->data_inicio = $data;
    }

    /**
     * @return mixed
     */
    public function getDataTermino()
    {
        return $this->data_termino;
    }

    /**
     * @param mixed $data_termino
     */
    public function setDataTermino($data_termino): void
    {
        $this->data_termino = $data_termino;
    }

    /**
     * @return mixed
     */
    public function getHorarioSaida()
    {
        return $this->horario_saida;
    }

    /**
     * @param mixed $horario_saida
     */
    public function setHorarioSaida($horario_saida): void
    {
        $this->horario_saida = $horario_saida;
    }

    /**
     * @return mixed
     */
    public function getHorarioChegada()
    {
        return $this->horario_chegada;
    }

    /**
     * @param mixed $horario_chegada
     */
    public function setHorarioChegada($horario_chegada): void
    {
        $this->horario_chegada = $horario_chegada;
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
    public function setPreco($preco): void
    {
        $this->preco = $preco;
    }

    /**
     * @return mixed
     */
    public function getObservacoes()
    {
        return $this->observacoes;
    }

    /**
     * @param mixed $observacoes
     */
    public function setObservacoes($observacoes): void
    {
        $this->observacoes = $observacoes;
    }

    /**
     * @return mixed
     */
    public function getStatusViagem()
    {
        return $this->status_viagem;
    }

    /**
     * @param mixed $status_viagem
     */
    public function setStatusViagem($status_viagem): void
    {
        $this->status_viagem = $status_viagem;
    }
    public function motoristasDisponiveis($ids_motoristas){
        $viagem_motorista = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->where('viagem.data_inicio',$this->getDataInicio())->get();

        $disponibilade = true;
        $pular = false;
        foreach ($viagem_motorista as $vm){
            foreach ($ids_motoristas as $ids){
                if ($vm->id_motorista == $ids){
                    $disponibilade = false;
                    $pular = true;
                    break;
                }else{
                    $disponibilade = true;
                }
            }
            if ($pular){
                break;
            }
        }
        return $disponibilade;
    }
    public function veiculosDisponiveis($ids_veiculos){
        $viagem_motorista = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->where('viagem.data_inicio',$this->getDataInicio())->get();

        $disponibilade = true;
        $pular = false;
        foreach ($viagem_motorista as $vm){
            foreach ($ids_veiculos as $ids){
                if ($vm->id_veiculo == $ids){
                    $disponibilade = false;
                    $pular = true;
                    break;
                }else{
                    $disponibilade = true;
                }
            }
            if($pular){
                break;
            }
        }
        return $disponibilade;
    }
    public function consultarViagensPaginateUsuario($paginas){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('viagem.data_inicio', ">=",date('Y-m-d'))->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->paginate($paginas);

        return $viagem;
    }
    public function consultarViagensPaginate($paginas){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->paginate($paginas);

        return $viagem;
    }

    public function groupPaginate($paginas){
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->groupBy('viagem.id_viagem')->paginate($paginas);

        return $viagem;
    }

    public function groupUserPaginate($paginas){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('viagem.data_inicio', ">=",date('Y-m-d'))->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->groupBy('viagem.id_viagem')->paginate($paginas);

        return $viagem;
    }
    public function groupconsultarViagens(){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select(DB::raw('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente'))->groupBy('viagem.id_viagem')->get();

        return $viagem;
    }
    public function consultarViagens(){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->get();

        return $viagem;
    }

    public function consultarViagensOrderRotina(){
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->orderBy('viagem.data_inicio','asc')->orderBy('viagem.horario_saida','asc')->get();

        return $viagem;
    }
    public function consultarViagem(){
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('viagem.id_viagem',$this->getIdViagem())->get();

        return $viagem;
    }

    public function unicoRegistro(){
        //colunas alteradas,
        /*
         * nome_fornecedor
         * cpf_cliente
         * nome_motorista
         * cpf_motorista
         * nome_cliente
         */
        $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('viagem.id_viagem',$this->getIdViagem())->first();

        return $viagem;
    }

    public function filtrar($paginas,$admin,ClienteCL $cliente, MotoristaCL $motorista){
        if($admin){
            $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('clientes.nome','like','%'.$cliente->getNome().'%')->orWhere('motorista.nome','like','%'.$motorista->getNome().'%')->orWhere('viagem.status_viagem','like','%'.$this->getStatusViagem().'%')->orWhereRaw('viagem.data_inicio between ? and ?',[$this->getDataInicio(),$this->getDataTermino()])->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->groupBy('viagem.id_viagem')->paginate($paginas);

            return $viagem;
        }else{
            $viagem = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->JOIN('clientes_viagem','clientes_viagem.id_viagem','=','viagem.id_viagem')->JOIN('clientes','clientes.id_cliente','=','clientes_viagem.id_cliente')->JOIN('fornecedor','fornecedor.id_fornecedor','=','viagem.id_fornecedor')->select('*','fornecedor.nome as nome_fornecedor','clientes.telefone as telefone_cl','clientes.cpf as cpf_cliente','motorista.nome as nome_motorista','motorista.cpf as cpf_motorista','clientes.nome as nome_cliente')->where('viagem.data_inicio', ">=",date('Y-m-d'))->where('clientes.nome','like','%'.$cliente->getNome().'%')->orWhere('motorista.nome','like','%'.$motorista->getNome().'%')->orWhere('viagem.status_viagem','like','%'.$this->getStatusViagem().'%')->orWhereRaw('viagem.data_inicio between ? and ?',[$this->getDataInicio(),$this->getDataTermino()])->orderBy('viagem.data_inicio','desc')->orderBy('viagem.horario_saida','desc')->groupBy('viagem.id_viagem')->paginate($paginas);

            return $viagem;
        }
    }


    public function agendar(){
        $viagem = new Viagem();
        $viagem->origem = $this->getOrigem();
        $viagem->destino = $this->getDestino();
        $viagem->local_origem = $this->getLocalOrigem();
        $viagem->local_destino = $this->getLocalDestino();
        $viagem->preco = $this->getPreco();
        $viagem->data_inicio = $this->getDataInicio();
        $viagem->horario_saida = $this->getHorarioSaida();
        $viagem->observacoes = $this->getObservacoes();
        $viagem->status_viagem = $this->getStatusViagem();
        $viagem->id_fornecedor = $this->getFornecedorCl()->getIdFornecedor();
        $viagem->save();
        //id da viagem inserida
        return DB::getPdo()->lastInsertId();
    }

    public function alterar(){
        Viagem::where('id_viagem',$this->getIdViagem())->update([
            "origem" => $this->getOrigem(),
            "destino" => $this->getDestino(),
            "local_origem" => $this->getLocalOrigem(),
            "local_destino" => $this->getLocalDestino(),
            "preco" => $this->getPreco(),
            "data_inicio" => $this->getDataInicio(),
            "horario_saida" => $this->getHorarioSaida(),
            "observacoes" => $this->getObservacoes(),
            "status_viagem" => $this->getStatusViagem(),
            "id_fornecedor" => $this->getFornecedorCl()->getIdFornecedor()
        ]);
    }


}

