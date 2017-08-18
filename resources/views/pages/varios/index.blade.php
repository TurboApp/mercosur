@extends('layouts.master')
@section('title','Varios')
@section('nav-top')

@endsection
@section('content')

<div class="row">
    
    <todo-list placeholder="Agrega un documento"  get-data="/tipodocumentos" set-data="" >        
    </todo-list>

</div><!-- ./row -->
@endsection

@push('scripts')


    
@endpush


