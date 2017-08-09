@extends('layouts.master')
@section('title','Añadir nuevo servicio')
@section('nav-top')
  <ul class="nav navbar-nav navbar-right">
  <li>
      <a href="{{ URL::previous() }}" rel="tooltip" data-placement="bottom" title="Ir atras">
          <i class="material-icons">arrow_back</i>
          <p class="hidden-lg hidden-md">Regresar</p>
      </a>
  </li>
  <li class="separator hidden-lg hidden-md"></li>
</ul>
<form class="navbar-form navbar-right" method="GET" action="/traficos/busqueda/" role="search">
  <div class="form-group form-search is-empty">
      <input type="text" class="form-control" name="s" placeholder="Buscar">
      <span class="material-input"></span>
  </div>
  <button type="submit" class="btn btn-white btn-round btn-just-icon">
      <i class="material-icons">search</i>
      <div class="ripple-container"></div>
  </button>
</form>
@endsection
@section('content')

                  <div class="container-fluid">
                      <div class="row">
                          <div class="col-md-12">
                              <h2>Nueva Orden de Servicio</h2>
                          </div>

                      </div>
                      <div class="card">
                        <div class="card-header card-header-icon" data-background-color="blue">
                          <i class="material-icons">assignment_turned_in</i>
                        </div>
                        <div class="card-content">
                          <div class="pull-right">
                            <p>
                              <i class="fa fa-calendar-o" aria-hidden="true"></i>
                              <span>19 de Julio del 2017</span>
                            </p>
                          </div>
                          <h4 class="card-title">Datos Generales</h4>
                          <div class="row">
                            <form class="form-inline">
                              <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label for="" class="label-on-left">Tipo de servicio</label>
                                      <select class="selectpicker" data-style="btn btn-primary btn-round " title="Single Select" data-size="7">
                                          <option disabled selected>Selecciona servicio</option>
                                          <option value="2">Carga</option>
                                          <option value="3">Descarga</option>
                                          <option value="">Trasbordo</option>
                                          <option value="">Otros servicios</option>
                                      </select>
                                    </div><!-- ./form-group -->
                                </div><!-- ./col -->
                                <div class="col-md-3 col-sm-6">
                                  <div class="form-group">
                                      <label for="">Asignado a</label>
                                      <select class="selectpicker" data-style="btn btn-primary btn-round" title="Single Select" data-size="7">
                                          <option disabled selected>Selecciona una opción</option>
                                          <option value="2">SISAA</option>
                                          <option value="3">Particular</option>
                                      </select>
                                    </div><!-- ./form-group -->
                                </div><!-- ./col -->
                              </form>
                            </div><!-- ./row -->
                            <hr>
                            <div class="row">
                              <div class="col-md-6">
                                <h4 class="card-title">Recepción de documentos</h4>
                              </div>
                              <div class="col-md-6">
                                <form class="form-horizontal">
                                  <div class="row">
                                      <label class="col-sm-2 label-on-left">Fecha</label>
                                      <div class="col-sm-4">
                                          <div class="form-group label-floating is-empty">
                                              <input type="text" class="form-control datepicker" value="10/10/2016">
                                          <span class="material-input"></span>
                                        </div>
                                      </div>
                                      <label class="col-sm-2 label-on-left">Fecha</label>
                                      <div class="col-sm-4">
                                          <div class="form-group label-floating is-empty">
                                              <label class="control-label"></label>
                                              <input type="text" class="form-control timepicker" value="10/10/2016">
                                          <span class="material-input"></span></div>
                                      </div>
                                  </div>
                                </form>
                              </div>
                            </div><!-- ./row -->
                            <div class="row">
                              <form class="form-horizontal">
                                   <div class="col-md-8 col-sm-6">
                                      <label class="col-md-2 label-on-left">Cliente</label>
                                          <div class="col-md-9">
                                             <div class="form-group label-floating is-empty">
                                               <label class="control-label"></label>
                                                  <input type="text" class="form-control">
                                                    <span class="help-block">Ingrese nombre del Cliente</span>
                                                     <span class="material-input"></span>
                                              </div>
                                          </div>
                                    </div>

                                   <div class="col-md-3 col-sm-6">
                                          <label class="col-sm-2 label-on-left">RFC</label>
                                              <div class="col-md-9">
                                                  <div class="form-group label-floating is-empty">
                                                      <label class="control-label"></label>
                                                      <input type="text" class="form-control">
                                                      <span class="help-block">Ingrese RFC del Cliente</span>
                                                      <span class="material-input"></span>
                                                  </div>
                                              </div>
                                    </div>
                              </form>
                            </div><!-- ./row -->

                            <div class="row">
                                  <form class="form-horizontal">
                                        <div class="col-md-8 col-sm-6">
                                          <label class="col-sm-2 label-on-left">Destinatario</label>
                                              <div class="col-md-9">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                      <input type="text" class="form-control">
                                                      <span class="help-block">Ingrese el nombre Destinatario</span>
                                                      <span class="material-input"></span>
                                                </div>
                                              </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6">
                                            <label class="col-sm-2 label-on-left">País</label>
                                              <div class="col-md-9">
                                                  <div class="btn-group bootstrap-select show-tick">
                                                      <select class="selectpicker" data-live-search="true" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">

                                                          <option value="1">Mexico</option>
                                                          <option value="2">Salvador</option>
                                                      </select>
                                                  </div>
                                              </div>
                                        </div>
                                  </form>
                            </div><!-- /row-->
                        </div><!-- ./card conted-->
                      </div><!--fin card-->

                      <div class="nav-center">
                          <ul class="nav nav-pills nav-pills-primary nav-pills-icons">
                              <li class="active"><a data-toggle="tab" role="tap" href="#trans"><i class="material-icons">local_shipping</i>Transporte</a></li>
                              <li><a data-toggle="tab" role="tap" href="#docs"><i class="material-icons">content_paste</i>Documentación</a></li>
                          </ul>
                      </div>
                      <div class="tab-content">
                          <div class="tab-pane fade in active" id="trans">
                              <div class="card">
                                  <div class="card-header card-header-tabs" data-background-color="blue">
                                                  <div class="nav-tabs-navigation">
                                                    <div class="nav-tabs-wrapper">
                                                      <span class="nav-tabs-title">Datos Transporte</span>
                                                      <ul class="nav nav-tabs" data-tabs="tabs">
                                                          <li class="active">
                                                              <a href="#client" data-toggle="tab">
                                                                 <i class="material-icons">person</i>
                                                                  Cliente
                                                                  <div class="ripple-container"></div>
                                                              </a>
                                                          </li>
                                                          <li>
                                                              <a href="#desti" data-toggle="tab">
                                                                  <i class="material-icons">account_circle</i>
                                                                  Destino
                                                                  <div class="ripple-container"></div>
                                                              </a>
                                                          </li>
                                                      </ul>
                                                    </div>
                                                  </div>
                                                </div>
                                      <div class="card-content">

                                          <!--<div class="row">-->
                                              <div class="row">

                                              </div>
                                              <div class="tab-content">
                                                  <div class="tab-pane fade in active" id="client">
                                                      <div class="form-horizontal">
                                                          <div class="row">
                                                              <div class="col-md-12 col-sm-12">
                                                                  <label class="col-md-2 label-on-left">Nombre de Operador</label>
                                                                  <div class="col-md-10">
                                                                       <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese nombre del Operador</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-5 label-on-left">Linea de Transporte</label>
                                                                  <div class="col-md-7">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la Linea de Transporte</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">N° de Talón</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese N° de Talón</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Cantidad</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la Cantidad</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-5 label-on-left">Marca Vehículo</label>
                                                                  <div class="col-md-7">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la marca</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Placas Tractor</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese Placas Tractor</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Placas Caja</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese Placas de Caja</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div><!--form trans-->
                                                  <form class="form-inline">
                                                      <div class="row">
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">Tipo Unidad</label>

                                                                      <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">Full</option>
                                                                              <option value="2">Plataforma</option>
                                                                              <option value="3">Caja</option>
                                                                          </select>
                                                                      </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">Medida Unidad</label>
                                                                     <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">4 Pies</option>
                                                                              <option value="2">10 Pies</option>
                                                                              <option value="3">20 Pie</option>
                                                                          </select>
                                                                      </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">N° Ejes</label>
                                                                    <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">4 Ejes</option>
                                                                              <option value="2">8 Ejes</option>
                                                                              <option value="3">10 Ejes</option>
                                                                          </select>
                                                                    </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </form>
                                                </div><!--content cLiente-->
                                                <div class="tab-pane fade" id="desti">
                                                      <div class="form-horizontal">
                                                          <div class="row">
                                                              <div class="col-md-12 col-sm-12">
                                                                  <label class="col-md-2 label-on-left">Nombre de Operador</label>
                                                                  <div class="col-md-10">
                                                                       <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese nombre del Operador</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-5 label-on-left">Linea de Transporte</label>
                                                                  <div class="col-md-7">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la Linea de Transporte</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">N° de Talón</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese N° de Talón</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Cantidad</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la Cantidad</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-5 label-on-left">Marca Vehículo</label>
                                                                  <div class="col-md-7">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese la marca</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Placas Tractor</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese Placas Tractor</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4">
                                                                  <label class="col-md-4 label-on-left">Placas Caja</label>
                                                                  <div class="col-md-8">
                                                                      <div class="form-group label-floating is-empty">
                                                                          <label class="control-label"></label>
                                                                          <input type="text" class="form-control">
                                                                          <span class="help-block">Ingrese Placas de Caja</span>
                                                                          <span class="material-input"></span>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div><!--form trans-->
                                                  <form class="form-inline">
                                                      <div class="row">
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">Tipo Unidad</label>

                                                                      <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">Full</option>
                                                                              <option value="2">Plataforma</option>
                                                                              <option value="3">Caja</option>
                                                                          </select>
                                                                      </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">Medida Unidad</label>
                                                                     <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">4 Pies</option>
                                                                              <option value="2">10 Pies</option>
                                                                              <option value="3">20 Pie</option>
                                                                          </select>
                                                                      </div>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4 col-sm-4">
                                                              <div class="form-group">
                                                                  <label class="label-on-left">N° Ejes</label>
                                                                    <div class="btn-group bootstrap-select show-tick">
                                                                          <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                              <option value="1">4 Ejes</option>
                                                                              <option value="2">8 Ejes</option>
                                                                              <option value="3">10 Ejes</option>
                                                                          </select>
                                                                    </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </form>
                                                </div><!--content destino-->
                                              </div><!--Tabcontenet form-->
                                          <!--</div>-->
                                      </div><!--fin card content-->
                                  </div><!--fin card-->
                              </div><!--tab trasnporte-->
                              <div class="tab-pane fade" id="docs">
                                  <div class="card">
                                      <div class="card-header card-header-icon" data-background-color="blue">
                                          <i class="material-icons">content_paste</i>
                                      </div>
                                          <div class="card-content">
                                              <h4 class="card-title">Documentos Mercancia</h4>
                                              <div class="form-horizontal">
                                                  <div class="row">
                                                      <div class="col-md-6 col-sm-6">
                                                          <label class="col-sm-7 label-on-left">Tipo Documento</label>
                                                          <div class="col-md-5 col-sm-5">
                                                              <div class="btn-group bootstrap-select show-tick">
                                                                  <select class="selectpicker" data-style="select-with-transition" title="Buscar" data-size="7" tabindex="-98">
                                                                  <option value="1">Factura</option>
                                                                  <option value="2">Hoja de Remición</option>
                                                                  </select>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6 col-sm-6">
                                                          <label class="col-sm-6 label-on-left">Control Documento</label>
                                                          <div class="col-sm-6">
                                                              <div class="form-group label-floating is-empty">
                                                                      <label class="control-label"></label>
                                                                      <input type="text" class="form-control">
                                                                      <span class="help-block"></span>
                                                                      <span class="material-input"></span>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-12">
                                                          <label class="col-sm-3 label-on-left">Descripción Documento</label>
                                                          <div class="col-sm-9">
                                                              <div class="form-group label-floating is-empty">
                                                                      <label class="control-label"></label>
                                                                      <input type="text" class="form-control">
                                                                      <span class="help-block">Ingrese Descripción del Documento</span>
                                                                      <span class="material-input"></span>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">

                                                          <h4 class="card-title text-center">Arrastre o Inserte archivo</h4>

                                                  </div>
                                                  <div class="row">
                                                      <div class="col-md-10 col-md-offset-1">
                                                          <div class="html5fileupload demo_multi" data-multiple="true" data-url="html5fileupload.php" style="width: 100%;">
                                                              <input type="file" name="file" />
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div><!--cardcontent documentos-->
                                     </div><!--card documetos-->

                             </div><!--- tab content-->
                          </div><!--tabdocumentos-->
                  </div><!-- ./container-fluid -->
                      <div class="text-center">
                          <button class="btn btn-primary btn-round btn-lg" data-toggle="modal" data-target="#exampleModalLong">
          	                  <i class="material-icons">find_in_page</i> Revisar
                          </button>
                          <!-- Modal -->
                              <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      Aqui va la Info del Form
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                  </div>
                                </div>
                              </div><!--modal fin-->
                      </div>

@endsection
@push('scripts')
  <script type="text/javascript">

    $(document).ready(function() {
        demo.initFormExtendedDatetimepickers();
    });

</script>
<script type="text/javascript">

    $('.html5fileupload.demo_multi').html5fileupload();
</script>
@endpush
