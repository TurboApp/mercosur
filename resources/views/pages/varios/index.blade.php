@extends('layouts.master')
@section('title','Varios')
@section('nav-top')

@endsection
@section('content')

<div class="row">
    <div class="col-md-12">
       <h4>Varios</h4>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Paises</h4>
                    <p class="category">Category subtitle</p>
                </div>
                <div class="card-content">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Pais</label>
                        
                        <input type="text" class="form-control typeahead">
                        
                    <span class="material-input"></span></div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>




        <div class="col-md-6">
            <div class="card">
	            <div class="card-header" data-background-color="blue">
		            <h4 class="card-title">Documentos</h4>
		            <p class="category"></p>
                </div>
                <div class="card-content">
                    <form class="form-horizontal" role="search">
                        <div class="form-group label-floating has-none">
                            <input type="text" class="form-control" placeholder="Agrega un docuemnto"/>
                            <span class="form-control-feedback">
                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                            </span>
                        </div>
                    </form>
                </div>
	            <div class="card-content  table-full-width">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <h4><i class="fa fa-file-text-o" aria-hidden="true"></i> Titulo del documento</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-primary btn-just-icon btn-round">
                                        <i class="material-icons">mode_edit</i>
                                    </button>
                                    <button class="btn btn-danger btn-just-icon btn-round ">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                            </div><!-- ./row -->
                        </li><!-- ./list-group-item -->
                        <li class="list-group-item editting" >
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-file-text-o fa-lg" aria-hidden="true"></i> 
                                            </span>
                                            <input type="text" value="Titulo del documento" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-success btn-just-icon btn-round">
                                        <i class="material-icons">check</i>
                                    </button>
                                    <button class="btn btn-warning btn-just-icon btn-round ">
                                        <i class="material-icons">close</i>
                                    </button>
                                </div>
                            </div><!-- ./row -->
                        </li><!-- ./list-group-item -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <h4><i class="fa fa-file-text-o" aria-hidden="true"></i> Titulo del documento</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-primary btn-just-icon btn-round">
                                        <i class="material-icons">mode_edit</i>
                                    </button>
                                    <button class="btn btn-primary btn-just-icon btn-round ">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                            </div><!-- ./row -->
                        </li><!-- ./list-group-item -->
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <h4><i class="fa fa-file-text-o" aria-hidden="true"></i> Titulo del documento</h4>
                                    </div>
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-primary btn-just-icon btn-round">
                                        <i class="material-icons">mode_edit</i>
                                    </button>
                                    <button class="btn btn-primary btn-just-icon btn-round ">
                                        <i class="material-icons">delete</i>
                                    </button>
                                </div>
                            </div><!-- ./row -->
                        </li><!-- ./list-group-item -->
                    </ul><!-- ./list-group -->
        

	</div>
</div>
		
          
       </div>
    </div><!-- ./col-md-12 -->

</div><!-- ./row -->
@endsection

@push('scripts')
<script>

    demo.getCountry('.typeahead');

</script>
<script>
    let mv = new Vue({
        data:{
            
        },
        computed:{

        },
        methods:{

        }
    });
</script>
    
@endpush


