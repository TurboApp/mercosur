@extends('pages.maniobra.master')

@section('content-page')
   
   {{Auth()->user()}}

    @if( Auth()->user()->perfil->perfil === 'supervisor')
        
        @include('pages.maniobra.detalles-supervisor')

    @else
        
        @include('pages.maniobra.detalles-coordinador')

    @endif


        
@endsection


  