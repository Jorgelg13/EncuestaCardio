<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class EncuestaController extends Controller
{
    public function guardar(Request $rq)
    {
        header('Access-Control-Allow-Origin: *');
        
        $table_name = 'encuesta';

        if ($rq->has('table_name'))
        {
            $table_name = $rq->table_name;    
        }

        $inputs = $rq->except(['table_name']);

        $data = DB::table("$table_name")->insert( $inputs );

        if($data)
        {
            header('Access-Control-Allow-Origin: *');

            return [
                "status" => true,
                "mensaje" => "Almacenado con exito.."
            ];
        }

        header('Access-Control-Allow-Origin: *');
        
        return [
            "status" => false,
            "mensaje" => "Error al intentar almacenar.."
        ];
    }
}