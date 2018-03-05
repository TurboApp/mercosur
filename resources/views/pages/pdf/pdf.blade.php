<page backtop="43mm" backbottom="11mm" backleft="0mm" backright="0mm">
  <page_header>
      <table style="width: 100%;" class="page_header">
          <tr>
            <td rowspan="2"><img src='img/mercosur.jpg' style="width:200px; height:75px;"/></td>
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
      @component('components.formato',[
        'data' => $data,
        'fecha' => $date,
        'tipo' => $data->tipo,
      ])
      @endcomponent()
</page>
