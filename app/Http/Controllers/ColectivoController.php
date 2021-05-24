<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mail;
use PDF;

class ColectivoController extends Controller
{
    public function envioColectivos(Request $request, $id)
    {
        header('Access-Control-Allow-Origin: *');
        $this->Guardar_Foto($request->Input('imagen'), $id);

        $data = DB::table('formulario_colectivo')->whereId($id)->first();
        $parametros = array('data' => $data );
        $email = "promotoresproteccion@unitypromotores.com";

        Mail::send('colectivos/mail', array(), function($message) use($parametros, $email, $id, $data) {
            $pdf = PDF::loadView('colectivos/pdf', $parametros);
            $message->to($email)->subject($data->nombre_asegurado_titular);
            $message->cc("unityhospitales@gmail.com");
            $message->attachData($pdf->output(),$id.".pdf");
        });

        return "enviado";

        header('Access-Control-Allow-Origin: *');
        return "archivo guardado";
    }

    public function verPdf($id)
    {
        $data = DB::table('formulario_colectivo')->whereId($id)->first();

        $parametros = array('data' => $data );

        //return $parametros;
        $pdf = PDF::loadView('colectivos/pdf', $parametros);
        return $pdf->stream();
    }


    public function Guardar_Foto($rawData, $id)
	{
		$filteredData = explode(',', $rawData);
		$unencoded = base64_decode($filteredData[1]);
		$url = "firmas/{$id}";
		$fp = fopen($url.'.png', 'w');
		fwrite($fp, $unencoded);
		fclose($fp);
	}
}
