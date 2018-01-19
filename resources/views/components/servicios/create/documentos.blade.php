@if( isset($servicio->id ))
    <select-document :data="{{$servicio->documentos}}"></select-document>
@else
    <add-document ></add-document>
@endif   
        

        
   