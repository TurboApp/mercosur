<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Servicio;
use Spipu\Html2Pdf\Html2Pdf;
use Carbon\Carbon;
use Jenssegers\Date\Date;


class PdfController extends Controller
{
    public function crearPDF($datos,$vistaurl,$tipo){
      $data = $datos;
        $date= ucfirst( Date::instance(Carbon::now())->format('l j \\d\\e F \\d\\e Y \\a \\l\\a\\s h:i A') );
        $fecha = date('d-m-Y');
        $view =  View::make($vistaurl, compact('data', 'date'))->render();
        if($tipo=='tarjeta'){
          $html2pdf = new Html2Pdf('L', 'LETTER', 'en','UTF-8');
          $html2pdf->pdf->SetDisplayMode('fullpage');
          $html2pdf->pdf->IncludeJS('print(TRUE)');
          $html2pdf->writeHTML($view);
          $html2pdf->output('reporte.pdf');  
        }else{
          $html2pdf = new Html2Pdf('P', 'LETTER', 'en','UTF-8');
          $html2pdf->pdf->SetDisplayMode('fullpage');
          $html2pdf->writeHTML($view);
          if($tipo=='previo'){
            return $html2pdf->output('reporte.pdf');
          }
          if($tipo=='download'){
            foreach ($data->transportes as $servicio){
              $name=$servicio->nombre_operador;
              return $html2pdf->output($name.$fecha.'.pdf','D');
            }
          }
          if($tipo=='print'){
            $html2pdf->pdf->IncludeJS('print(TRUE)');
            return $html2pdf->output('reporte.pdf');
          }
        }
    }

    public function previo(Servicio $servicio, $tipo){
      if($tipo=='tarjeta'){
        $vistaurl="pages.pdf.tarjeta";
        return $this->crearPDF($servicio, $vistaurl,$tipo);
      }else{
        $vistaurl="pages.pdf.pdf";
        return $this->crearPDF($servicio, $vistaurl, $tipo);
      }
    }
}
