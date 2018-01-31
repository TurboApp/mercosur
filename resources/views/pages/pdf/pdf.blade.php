<page backtop="43mm" backbottom="11mm" backleft="4mm" backright="0mm">
  <page_header>
      <table style="width: 100%;" class="page_header">
          <tr>
            <td rowspan="2"><img src='/laragon/www/mercosur/public/img/mercosur.jpg' style="width:200px; height:75px;"/></td>
            <td style='font-weight: bold; font-size: 16pt; color: #2962FF; font-family: Times; text-align:center; padding:10px;'>COMERCIALIZADORA MERCOSUR, S.A. DE C.V.<br>
              <span style='font-weight: bold; font-size: 12pt; color: #B71C1C; font-family: Times; text-align:center; padding:10px;'>R.F.C: CME-031220-GYA</span><br>
              <span><hr></span>
            </td>
          </tr>
          <tr>
            <td style='font-size: 10pt; color: #37474F; font-family: Times; text-align:center; padding:2px;'>
              IMPORTACIÓN, EXPORTACIÓN, ALMACEN Y MANEJO DE MERCANCIAS<br>
              <span>KM. 1.5 CARRETERA CD. HIDALGO-TAPACHULA C.P. 30840 CD. HIDALGO, CHIAPAS.</span><br>
              <span>TEL.(01962) 627 10 32 FAX 627 10 31</span><br>
            </td>
          </tr>
      </table>
  </page_header>
  <page_footer>
      <table style="width: 100%;">
          <tr>
              <td style="text-align: left;    width: 100%"><span style='font-weight: bold; font-size: 9pt; color: #FF3D00; font-family: Times;'>Nota: Por cualquier irregularidad después de recibido o entregado la mercancía no aceptamos reclamaciones algunas.</span></td>
          </tr>
      </table>
  </page_footer>
  <table border=".5px" cellspacing="0" bordercolor="Blue Grey">
    <tr>
        <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DE LA  MERCANCIA QUE SE ENTREGO O RECIBIO EN BODEGA</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Ciudad Hidalgo, Chiapas: <span style="font-weight: bold; font-size: 8pt;">{{$date}}</span></td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">El suscrito operador: 
          <strong>
            @foreach ($data->transportes as $servicio)
              {{ucwords($servicio->nombre_operador)}}
            @endforeach
          </strong>
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Fecha y hora de entrega de documentos:
          <strong>
            {{$data->fecha_recepcion->format('d/m/Y')}} a las {{date('h:i A',strtotime($data->hora_recepcion))}} 
          </strong>
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Inicio de maniobras:
          <strong>
            {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->inicio_maniobra))}}
          </strong>
        </td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Finalización de maniobra:
          <strong>
            {{date('d/m/Y \\a \\l\\a\\s h:i A',strtotime($data->coordinacion->termino_maniobra))}}
          </strong>
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Me Recibieron Mercancia:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Me Entregaron Mercancia:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Mercancia del Cliente:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con destino al cliente</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">cant/bts</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Con peso de</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Talon:
          <strong>
            @foreach ($data->transportes as $servicio)
              {{ucfirst($servicio->talon_embarque)}}
            @endforeach
          </strong>
        </td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Fact o Rem. N°:
          @foreach ($data->documentos as $servicio)
              <strong>{{ucfirst($servicio->tipo_documento)}}-{{$servicio->num_documento}}</strong>
          @endforeach
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observación de la mercancia:</td>
      </tr>
      <tr>
        <td colspan="3" style='font-weight: bold; font-size: 10pt; color: #000000; font-family: Times; text-align:center; padding:10px;'>DATOS DEL VEHICULO QUE ENTREGO O RECIBIO LA MERCANCIA</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Tipo de transporte:
          @foreach ($data->transportes as $servicio)
              <strong>{{ucfirst($servicio->tipo_unidad)}}</strong>
          @endforeach
        </td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Medias:
          <strong>
            @foreach ($data->transportes as $servicio)
              {{ucfirst($servicio->medida_unidad)}}
            @endforeach
          </strong>
        </td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000;'>
            @foreach ($data->transportes as $servicio)
              <p>Placas Caja: <strong>{{ucfirst($servicio->placas_caja)}}</strong></p>  
              <span style='display:block'>Placas Tractor: <strong>{{ucfirst($servicio->placas_tractor)}}</strong></span>
            @endforeach
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Linea de transporte:
          <strong>
            @foreach ($data->transportes as $servicio)
              {{ucfirst($servicio->transporte->nombre)}}
            @endforeach
          </strong>
        </td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Estado de la plataforma:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Llantas en buen estado:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Las llantas traen la presión adecuada:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Traen la totalidad de tuercas en las llantas:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Llantas de repuesto:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Herramientas y señales reflejantes:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Lonas en buen estado:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con lona:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;'>Cuenta con cadenas, Lazos, Slingas y Fajas para ajustar el material y en buenestado:</td>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="2">Que tipo:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Funcionamiento de luces Indicadoras, Direccionales y/o Faros en buen estado:</td>
      </tr>
      <tr>
        <td style='font-weight: italic; font-size: 8pt; color: #000000; padding:7px;' colspan="3">Observaciones Generales de la plantaforma o caja:</td>
      </tr>
      <tr>
        <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;'>
          <span>ENTREGO</span><br><br>
          <span>________________________</span><br>
          <span>{{$data->autor->nombre}} {{$data->autor->apellido}}</span>
        </td>
        <td style='font-size: 10pt; color: #000000; font-weight: italic; text-align:center; padding:6px;' colspan="2">
          <span>RECIBIO</span><br><br>
          <span>________________________</span><br>
          <span>@foreach ($data->transportes as $servicio)
              {{ucwords($servicio->nombre_operador)}}
            @endforeach
          </span>
        </td>
      </tr>
  </table>
</page>
