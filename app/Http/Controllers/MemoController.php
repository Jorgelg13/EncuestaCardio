<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;
use PDF;


class MemoController extends Controller
{

    private $varDescripcion = [
        "A"   => "Inclusion de Asegurado Principal",
        "B"   => "Exclusiones",
        "IGM" => "Inclusiones GM/Vida",
        "ID"  => "Inclusión de Dependientes",
        "DC"  => "Duplicado de Carnet",
        "CP"  => "Cambio de Plan"
    ];


    public function demo(Request $rq, $tipo)
    {
        if($tipo == "ID") {

        }
        else {
            return $this->memoGeneral($rq, $tipo);
        }
    }

    public function memoInclusionDependientes(Type $var = null)
    {
       
    }

    public function memoGeneral($rq, $tipo)
    {
        $encabezado = [
            "nombre" => $rq->enc_nombre,
            "empresa" => $rq->enc_empresa,
            "direccion" => $rq->enc_direccion,
            "fecha" => Carbon::now(),
            "solicitud" => $rq->enc_solicitud
        ];

        $cliente = [
            "asegurado" => $rq->cli_asegurado,
            "poliza" => $rq->cli_poliza,
            "ramo" => $rq->cli_ramo
        ];

        $cuerpo = [
            "descripcion" => $this->varDescripcion[$tipo],
            "observacion" => $rq->body_observacion
        ];

        $firma = [
            'ejecutivo' => $rq->ejecutivo,
            'backoffice' => $rq->backoffice                                             
        ];

        $data = [
            "encabezado" => $encabezado,
            "cliente" => $cliente,
            "cuerpo" => $cuerpo,
            "firma" => $firma
        ];

        $pdf = PDF::loadView('memos.inclusion-gm-vida', $data);

        return $pdf->stream();
    }
}