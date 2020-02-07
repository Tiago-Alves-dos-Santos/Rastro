<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Classes;
use Illuminate\Support\Facades\DB;
use PDF;
class MotoristaVViagemC extends Controller
{
    //calcula o slario do mes, de um motorista
    public function salarioPdf(Request $req){
        $motorista = new Classes\MotoristaCL();
        $viagem = new Classes\ViagemCL();
        $motorista->setIdMotorista((int) $req->id_motorista);
        $viagem->setDataInicio($req->salario,'Y-m');
        //todas as viagen e veiculos usado pelo motorista naquele mes
        $viagem_feitas = DB::table("motorista_viagem")->JOIN("motorista", "motorista.id_motorista","=","motorista_viagem.id_motorista")->JOIN("veiculo","veiculo.id_veiculo","=","motorista_viagem.id_veiculo")->JOIN("viagem","viagem.id_viagem","=","motorista_viagem.id_viagem")->where('motorista.id_motorista',$motorista->getIdMotorista())->where('viagem.data_inicio','like','%'.$viagem->getDataInicio().'%')->get();
        $soma_valor_viagem = 0;
        $locais = [];
       foreach ($viagem_feitas as $v){
           //calcula valor das viagens, caso queira colocar porcetagem por viagem faça aq, pois aq estamos
           //pegando o valor total de cada viagem e simplesmnete somando
           $soma_valor_viagem += $v->preco;
           //aramazena os locais viajados
           $locais[] = $v->origem.' para '.$v->destino;
       }
       //verfica os locais vijados e quantas vezes sao prepetidos
       $locais = array_count_values($locais);

       //todas as depesas daquele mes
       $depesas = Models\Despesas::where('id_motorista',$motorista->getIdMotorista())->where('data','like','%'.$viagem->getDataInicio().'%')->get();

       $soma_despesas = 0;
       foreach ($depesas as $d){
           //calcula valor das depesas
           $soma_despesas += $d->preco;
       }
        $mes = date('m/Y',strtotime($viagem->getDataInicio()));
       $salario = $soma_valor_viagem - $soma_despesas;
       //modifcando datas formato brasileiro
        foreach ($viagem_feitas as $v){
            $v->data_inicio = date('d/m/Y',strtotime($v->data_inicio));
        }
        foreach ($depesas as $d){
            $d->data = date('d/m/Y',strtotime($d->data));
        }
        //viagemfeita e desepesas e salario
        $motorista = Models\Motorista::where('id_motorista',$motorista->getIdMotorista())->first();
        $pdf = PDF::loadView('pdf.salario_motorista', compact('viagem_feitas','depesas','salario','motorista','locais','mes'));
        $pdf->setPaper('A4', 'portrait');
        //nome do pdf, vc pode colocar para download
        return $pdf->stream('salario'.date('m/Y').'.pdf');



    }
}
