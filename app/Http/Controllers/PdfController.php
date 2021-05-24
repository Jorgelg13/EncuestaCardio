<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;
use PDF;


class PdfController extends Controller
{
    public function codoReclamo(Request $rq)
    {
        $fecha = $rq->fecha;


        $data = DB::table('reclamos_medicos')
        ->select(
            "reclamos_medicos.id",
            "reg_reclamos_medicos.asegurado",
            "reg_reclamos_medicos.poliza",
            "detalle_pagos_reclamos_medicos.no_cheque",
            "reclamos_medicos.direccion", 
            "reclamos_medicos.destino",
            "reclamos_medicos.fecha_cierre"
        )
        ->join("reg_reclamos_medicos", "reg_reclamos_medicos.id","reclamos_medicos.id_reg_reclamos_medicos")
        ->join("detalle_pagos_reclamos_medicos", "detalle_pagos_reclamos_medicos.id_reclamo_medico","reclamos_medicos.id")
        ->where("reg_reclamos_medicos.tipo", 'I')
        ->whereRaw("CONVERT(DATE, [fecha_cierre], 103) = '$fecha'")
        ->orderBy('reg_reclamos_medicos.poliza', 'asc')
        ->get();

        $poliza = "";
        $regId = '';
        $regCheque = '';

        foreach($data as $key => $reg){
            if($poliza == $reg->poliza){
                $reg->id = $reg->id . ', ' . $regId;
                $reg->no_cheque = $reg->no_cheque . ', ' . $regCheque;

                unset($data[$key-1]);
            }
            $regId = $reg->id;
            $regCheque = $reg->no_cheque;
            $poliza = $reg->poliza;
        }

        $pdf = PDF::loadView('reclamos.codo', ["data" => $data]);

        return $pdf->stream();
    }
}
