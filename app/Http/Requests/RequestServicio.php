<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestServicio extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $datos_generales = [
            'datos_generales.cliente_id'      => 'required|max:11',
            'datos_generales.agente_id'       => 'required|max:11',
            'datos_generales.fecha_recepcion' => 'required',
            'datos_generales.hora_recepcion'  => 'required',
            'datos_generales.destino'         => 'required|max:191',
            'datos_generales.destino_pais'    => 'required|max:60',
        ];

        $transportesDescarga = [
            'transporte.Descarga.id_linea_transporte'  => 'required|max:11',
            'transporte.Descarga.nombre_operador'      => 'required|max:120',
            'transporte.Descarga.talon_embarque'       => 'required|max:191',
            'transporte.Descarga.marca_vehiculo'       => 'required|max:191',
            'transporte.Descarga.placas_tractor'       => 'required|max:191',
            'transporte.Descarga.placas_caja'          => 'required|max:191',
            'transporte.Descarga.tipo_unidad'          => 'required|max:191',
            'transporte.Descarga.medida_unidad'        => 'required|max:30',
            'transporte.Descarga.ejes'                 => 'required|max:25',
            'transporte.Descarga.cantidad'             => 'required|max:2',   
        ];
        $transportesCarga = [
            'transporte.Carga.id_linea_transporte'  => 'required|max:11',
            'transporte.Carga.nombre_operador'      => 'required|max:120',
            'transporte.Carga.talon_embarque'       => 'required|max:191',
            'transporte.Carga.marca_vehiculo'       => 'required|max:191',
            'transporte.Carga.placas_tractor'       => 'required|max:191',
            'transporte.Carga.placas_caja'          => 'required|max:191',
            'transporte.Carga.tipo_unidad'          => 'required|max:191',
            'transporte.Carga.medida_unidad'        => 'required|max:30',
            'transporte.Carga.ejes'                 => 'required|max:25',
            'transporte.Carga.cantidad'             => 'required|max:2',  
        ];
        
        switch($this->request->get('tipo')){
            case 'Descarga':
                $rules = $datos_generales + $transportesDescarga;
            break;
            case 'Carga':
                $rules = $datos_generales + $transportesCarga;
            break;
            case 'Trasbordo':
                $rules = $datos_generales + $transportesDescarga + $transportesCarga;
            break;
        }

        foreach($this->request->get('documento') as $key => $val)
        {
            if( $this->request->get('tipo') === 'Carga' )
            {
                
                $rules['documento.'.$key.'.id'] = 'required';
                
            }
            else
            {
                
                $rules['documento.'.$key.'.tipo_documento'] = 'required|max:45';
                $rules['documento.'.$key.'.documento'] = 'required|max:60';

            }
        }
        return $rules;
    }

    public function messages()
    {
        $messages['datos_generales.cliente_id.required'] = 'Por favor seleccione un cliente valido';
        $messages['datos_generales.agente_id.required'] = 'Por favor Seleccione el un agente';
        $messages['datos_generales.fecha_recepcion.required'] = 'La fecha de recepción es obligatoria';
        $messages['datos_generales.hora_recepcion.required'] = 'La hora de recepción es obligatoria';
        $messages['datos_generales.destino.required'] = 'El campo destinatario es requerido';
        $messages['datos_generales.destino_pais.required'] = 'El país destino es obligatorio';
        
        $messages['transporte.Descarga.id_linea_transporte.required'] = 'Por favor seleccione una linea de transporte valida';
        $messages['transporte.Descarga.nombre_operador.required'] = 'El nombre del opreador es requerido';
        $messages['transporte.Descarga.talon_embarque.required'] = 'El numero de talon de obligarotio';
        $messages['transporte.Descarga.marca_vehiculo.required'] = 'La marca de vehiculo es un dato obligatorio';
        $messages['transporte.Descarga.placas_tractor.required'] = 'Las placas del tractor es un campo obligatorio';
        $messages['transporte.Descarga.placas_caja.required'] = 'Las placas de la caja es un campo obligatorio';
        $messages['transporte.Descarga.tipo_unidad.required'] = 'El tipo de unidad es requerido';
        $messages['transporte.Descarga.medida_unidad.required'] = 'Las medidas de la unidad es un campo requerido';
        $messages['transporte.Descarga.ejes.required'] = 'El numero de ejes es un campo requerido';
        $messages['transporte.Descarga.cantidad.required'] = 'La cantidad es un campo requerido';
        
        $messages['transporte.Carga.id_linea_transporte.required'] = 'Por favor seleccione una linea de transporte valida';
        $messages['transporte.Carga.nombre_operador.required'] = 'El nombre del opreador es requerido';
        $messages['transporte.Carga.talon_embarque.required'] = 'El numero de talon de obligarotio';
        $messages['transporte.Carga.marca_vehiculo.required'] = 'La marca de vehiculo es un dato obligatorio';
        $messages['transporte.Carga.placas_tractor.required'] = 'Las placas del tractor es un campo obligatorio';
        $messages['transporte.Carga.placas_caja.required'] = 'Las placas de la caja es un campo obligatorio';
        $messages['transporte.Carga.tipo_unidad.required'] = 'El tipo de unidad es requerido';
        $messages['transporte.Carga.medida_unidad.required'] = 'Las medidas de la unidad es un campo requerido';
        $messages['transporte.Carga.ejes.required'] = 'El numero de ejes es un campo requerido';
        $messages['transporte.Carga.cantidad.required'] = 'La cantidad es un campo requerido';
    
      foreach($this->request->get('documento') as $key => $val)
      {

        $messages['documento.'.$key.'.tipo_documento.required'] = 'El Tipo de documento es obligatorio. Vuelva a intentarlo';
        $messages['documento.'.$key.'.documento.required'] = 'El Nombre ó Numero de documento es requerido. Vuelva a intentarlo';
        $messages['documentos.'.$key.'.id.required'] = 'Por favor seleccione almenos un documento para realizar la carga';
        
      }
      return $messages;
    }
}
