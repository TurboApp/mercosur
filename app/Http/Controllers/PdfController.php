<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\User;
use Spipu\Html2Pdf\Html2Pdf;
use Carbon\Carbon;
use Jenssegers\Date\Date;


class PdfController extends Controller
{
    public function crearPDF($datos,$vistaurl,$tipo){
      $data = $datos;
        $date= ucfirst( Date::instance(Carbon::now())->format('l j \\d\\e F \\d\\e Y \\a \\l\\a\\s h:i A') );
        $view =  View::make($vistaurl, compact('data', 'date'))->render();
        $html2pdf = new Html2Pdf('P', 'LETTER', 'en','UTF-8');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($view);
        if($tipo==1){
          return $html2pdf->output('reporte.pdf');
        }
        if($tipo==2){
          return $html2pdf->output('reporte.pdf','D');
        }
        if($tipo==3){
          $html2pdf->pdf->IncludeJS('print(TRUE)');
          return $html2pdf->output('reporte.pdf');
        }
    }

    public function previo(User $usuario, $tipo){
      $vistaurl="pages.pdf.pdf";
      return $this->crearPDF($usuario, $vistaurl, $tipo);
    }
}
